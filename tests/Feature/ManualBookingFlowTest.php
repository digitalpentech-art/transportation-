<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Route;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManualBookingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_step_by_step_booking_workflow()
    {
        // 1. Setup: Create route and vehicle with capacity 1
        $driver = User::create(['name' => 'Driver', 'email' => 'd@d.com', 'password' => 'password', 'role' => 'driver']);
        $p1 = User::create(['name' => 'P1', 'email' => 'p1@p.com', 'password' => 'password', 'role' => 'passenger']);
        $p2 = User::create(['name' => 'P2', 'email' => 'p2@p.com', 'password' => 'password', 'role' => 'passenger']);

        $route = Route::create([
            'origin' => 'City A',
            'destination' => 'City B',
            'departure_time' => now()->addDays(2),
        ]);

        Vehicle::create([
            'vehicle_type' => 'Bus',
            'capacity' => 1,
            'route_id' => $route->id,
            'driver_id' => $driver->id,
        ]);

        // 2. Step: Passenger 1 books a ride (should be Pending)
        $this->actingAs($p1);
        $this->withoutMiddleware();
        $response = $this->post(route('passenger.book'), ['route_id' => $route->id]);
        $response->assertStatus(302);
        
        $this->assertDatabaseHas('bookings', [
            'user_id' => $p1->id,
            'status' => 'Pending'
        ]);

        // 3. Step: Passenger 2 attempts to book (should be Waiting)
        $this->actingAs($p2);
        $this->post(route('passenger.book'), ['route_id' => $route->id]);
        
        $this->assertDatabaseHas('bookings', [
            'user_id' => $p2->id,
            'status' => 'Waiting'
        ]);

        // 4. Step: Driver cancels Passenger 1's booking
        $booking1 = Booking::where('user_id', $p1->id)->first();
        $this->actingAs($driver);
        $this->patch(route('driver.bookings.update-status', $booking1), ['status' => 'Cancelled']);
        
        // 5. Verify: Passenger 1 is Cancelled, Passenger 2 is promoted to Pending
        $this->assertEquals('Cancelled', $booking1->fresh()->status);
        $this->assertEquals('Pending', Booking::where('user_id', $p2->id)->first()->status);
    }
}
