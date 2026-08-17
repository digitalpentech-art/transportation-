<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PassengerBookingWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_passenger_can_book_a_ride()
    {
        // 1. Create a passenger
        $user = User::factory()->create(['role' => 'passenger']);
        
        // 2. Create a route
        $route = Route::create([
            'origin' => 'Maiduguri',
            'destination' => 'Biu',
            'departure_time' => now()->addDays(1),
        ]);

        \App\Models\Vehicle::create([
            'vehicle_type' => 'Bus',
            'capacity' => 10,
            'route_id' => $route->id,
            'driver_id' => User::factory()->create(['role' => 'driver'])->id,
        ]);

        // 3. Authenticate and visit booking page
        $this->actingAs($user);
        $this->withoutMiddleware();
        $response = $this->get(route('passenger.book'));
        $response->assertStatus(200);
        $response->assertSee('Maiduguri');

        // 4. Submit booking
        $response = $this->post(url('/passenger/book'), [
            'route_id' => $route->id,
        ]);

        // 5. Verify booking exists in DB
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'route_id' => $route->id,
            'status' => 'Pending',
        ]);

        // 6. Redirect to history
        $response->assertRedirect(route('passenger.history'));
    }
}

