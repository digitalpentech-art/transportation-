<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Route;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingEnhancementTest extends TestCase
{
    use RefreshDatabase;

    public function test_passenger_cannot_book_the_same_route_twice()
    {
        $user = User::factory()->create(['role' => 'passenger']);
        $route = Route::create([
            'origin' => 'Maiduguri',
            'destination' => 'Biu',
            'departure_time' => now()->addDays(1),
        ]);

        // Ensure enough capacity
        Vehicle::create([
            'vehicle_type' => 'Bus',
            'capacity' => 10,
            'route_id' => $route->id,
            'driver_id' => User::factory()->create(['role' => 'driver'])->id,
        ]);

        $this->actingAs($user);
        $this->withoutMiddleware();

        // First booking
        $this->post(route('passenger.book'), ['route_id' => $route->id]);
        
        // Second booking (should fail or redirect with error)
        $response = $this->post(route('passenger.book'), ['route_id' => $route->id]);
        
        $response->assertSessionHas('error', 'You have already booked this route.');
        $this->assertEquals(1, Booking::where('user_id', $user->id)->where('route_id', $route->id)->count());
    }

    public function test_passenger_is_added_to_waiting_list_if_route_is_full()
    {
        $user = User::factory()->create(['role' => 'passenger']);
        $otherUser = User::factory()->create(['role' => 'passenger']);
        
        $route = Route::create([
            'origin' => 'Maiduguri',
            'destination' => 'Biu',
            'departure_time' => now()->addDays(1),
        ]);

        // Create a vehicle with capacity 1
        Vehicle::create([
            'vehicle_type' => 'Bus',
            'capacity' => 1,
            'route_id' => $route->id,
            'driver_id' => User::factory()->create(['role' => 'driver'])->id,
        ]);

        $this->actingAs($user);
        $this->withoutMiddleware();

        // First user books the only seat
        Booking::create([
            'user_id' => $otherUser->id,
            'route_id' => $route->id,
            'status' => 'Confirmed',
            'booking_time' => now(),
        ]);
        
        // Second user tries to book
        $response = $this->post(route('passenger.book'), ['route_id' => $route->id]);

        $response->assertRedirect(route('passenger.history'));
        $response->assertSessionHas('success', 'This route is fully booked. You have been added to the waiting list.');
        
        $this->assertEquals(2, Booking::where('route_id', $route->id)->count());
        $this->assertEquals('Waiting', Booking::where('user_id', $user->id)->first()->status);
    }

    public function test_passenger_is_promoted_from_waiting_list_when_booking_is_cancelled()
    {
        \Illuminate\Support\Facades\Notification::fake();

        $driver = User::factory()->create(['role' => 'driver']);
        $passenger1 = User::factory()->create(['role' => 'passenger']);
        $passenger2 = User::factory()->create(['role' => 'passenger']);
        
        $route = Route::create([
            'origin' => 'Maiduguri',
            'destination' => 'Biu',
            'departure_time' => now()->addDays(1),
        ]);

        Vehicle::create([
            'vehicle_type' => 'Bus',
            'capacity' => 1,
            'route_id' => $route->id,
            'driver_id' => $driver->id,
        ]);

        // Passenger 1 books the only seat
        $booking1 = Booking::create([
            'user_id' => $passenger1->id,
            'route_id' => $route->id,
            'status' => 'Pending',
            'booking_time' => now(),
        ]);

        // Passenger 2 joins waiting list
        $booking2 = Booking::create([
            'user_id' => $passenger2->id,
            'route_id' => $route->id,
            'status' => 'Waiting',
            'booking_time' => now()->addMinutes(1),
        ]);

        $this->actingAs($driver);
        $this->withoutMiddleware();
        
        // Driver cancels Passenger 1's booking
        $response = $this->from(route('driver.dashboard'))
            ->patch(route('driver.bookings.update-status', $booking1), ['status' => 'Cancelled']);
        
        $response->assertSessionHas('success');
        
        $this->assertEquals('Cancelled', $booking1->fresh()->status);
        $this->assertEquals('Pending', $booking2->fresh()->status);

        \Illuminate\Support\Facades\Notification::assertSentTo($passenger1, \App\Notifications\BookingStatusUpdated::class);
        \Illuminate\Support\Facades\Notification::assertSentTo($passenger2, \App\Notifications\BookingStatusUpdated::class);
    }
}
