<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Route;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }

    public function test_admin_can_assign_route_to_vehicle()
    {
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class, 'role']);
        $driver = User::create(['name' => 'Driver', 'email' => 'd@d.com', 'password' => 'password', 'role' => 'driver']);
        $vehicle = Vehicle::create([
            'vehicle_type' => 'Bus',
            'capacity' => 10,
            'driver_id' => $driver->id
        ]);
        $route = Route::create([
            'origin' => 'A',
            'destination' => 'B',
            'departure_time' => now()->addDays(1)
        ]);

        $this->actingAs($this->admin);
        
        $response = $this->put(route('admin.vehicles.update', $vehicle), [
            'vehicle_type' => 'Bus Updated',
            'capacity' => 15,
            'driver_id' => $driver->id,
            'route_id' => $route->id
        ]);

        $response->assertRedirect(route('admin.vehicles.index'));
        $this->assertEquals($route->id, $vehicle->fresh()->route_id);
    }

    public function test_admin_can_assign_vehicles_to_route()
    {
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class, 'role']);
        $driver1 = User::create(['name' => 'Driver 1', 'email' => 'd1@d.com', 'password' => 'password', 'role' => 'driver']);
        $driver2 = User::create(['name' => 'Driver 2', 'email' => 'd2@d.com', 'password' => 'password', 'role' => 'driver']);
        
        $v1 = Vehicle::create(['vehicle_type' => 'Bus 1', 'capacity' => 10, 'driver_id' => $driver1->id]);
        $v2 = Vehicle::create(['vehicle_type' => 'Bus 2', 'capacity' => 10, 'driver_id' => $driver2->id]);
        
        $route = Route::create([
            'origin' => 'A',
            'destination' => 'B',
            'departure_time' => now()->addDays(1)
        ]);

        $this->actingAs($this->admin);

        $response = $this->put(route('admin.routes.update', $route), [
            'origin' => 'A Updated',
            'destination' => 'B Updated',
            'departure_time' => now()->addDays(1)->toDateTimeString(),
            'vehicle_ids' => [$v1->id, $v2->id]
        ]);

        $response->assertRedirect(route('admin.routes.index'));
        $this->assertEquals($route->id, $v1->fresh()->route_id);
        $this->assertEquals($route->id, $v2->fresh()->route_id);
    }

    public function test_admin_can_unassign_vehicles_from_route()
    {
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class, 'role']);
        $driver = User::create(['name' => 'Driver', 'email' => 'd@d.com', 'password' => 'password', 'role' => 'driver']);
        $route = Route::create(['origin' => 'A', 'destination' => 'B', 'departure_time' => now()->addDays(1)]);
        $v = Vehicle::create(['vehicle_type' => 'Bus', 'capacity' => 10, 'driver_id' => $driver->id, 'route_id' => $route->id]);

        $this->actingAs($this->admin);

        // Update route with NO vehicle_ids
        $response = $this->put(route('admin.routes.update', $route), [
            'origin' => 'A',
            'destination' => 'B',
            'departure_time' => now()->addDays(1)->toDateTimeString(),
            'vehicle_ids' => []
        ]);

        $response->assertRedirect(route('admin.routes.index'));
        $this->assertNull($v->fresh()->route_id);
    }
}
