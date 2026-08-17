<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Route;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@transport.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Driver
        $driver = User::create([
            'name' => 'John Driver',
            'email' => 'driver@transport.com',
            'password' => Hash::make('password'),
            'role' => 'driver',
        ]);

        // Create Passenger
        $passenger = User::create([
            'name' => 'Alice Passenger',
            'email' => 'passenger@transport.com',
            'password' => Hash::make('password'),
            'role' => 'passenger',
        ]);

        // Create Vehicle for Driver
        Vehicle::create([
            'vehicle_type' => 'Bus',
            'driver_id' => $driver->id,
        ]);

        // Create Sample Routes
        $route1 = Route::create([
            'origin' => 'Maiduguri',
            'destination' => 'Biu',
            'departure_time' => now()->addDays(1)->setHour(8)->setMinute(0),
        ]);

        $route2 = Route::create([
            'origin' => 'Maiduguri',
            'destination' => 'Potiskum',
            'departure_time' => now()->addDays(1)->setHour(10)->setMinute(30),
        ]);

        // Create a sample booking
        Booking::create([
            'user_id' => $passenger->id,
            'route_id' => $route1->id,
            'status' => 'Pending',
            'booking_time' => now(),
        ]);
    }
}
