<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Route;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManualTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Driver
        $driver = User::create([
            'name' => 'Test Driver',
            'email' => 'driver@transport.test',
            'password' => Hash::make('password'),
            'role' => 'driver',
        ]);

        // 2. Create Passenger
        $passenger = User::create([
            'name' => 'Test Passenger',
            'email' => 'passenger@transport.test',
            'password' => Hash::make('password'),
            'role' => 'passenger',
        ]);

        // 3. Create Admin
        $admin = User::create([
            'name' => 'Test Admin',
            'email' => 'admin@transport.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 3. Create Route
        $route = Route::create([
            'origin' => 'Maiduguri',
            'destination' => 'Biu',
            'departure_time' => now()->addDays(3),
        ]);

        // 4. Create Vehicle (Capacity 1 to allow waitlist testing)
        Vehicle::create([
            'vehicle_type' => 'Bus',
            'capacity' => 1,
            'route_id' => $route->id,
            'driver_id' => $driver->id,
        ]);
    }
}
