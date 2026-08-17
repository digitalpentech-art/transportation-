<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DebugCapacity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:capacity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Assigning vehicles to route 4...");
        \App\Models\Vehicle::query()->update(['route_id' => 4]);

        $this->info("Vehicles:");
        foreach (\App\Models\Vehicle::all() as $v) {
            $this->info("ID: {$v->id} | Route ID: {$v->route_id} | Capacity: {$v->capacity}");
        }

        $this->info("Routes:");
        foreach (\App\Models\Route::all() as $route) {
            $totalCapacity = $route->vehicles->sum('capacity');
            $currentBookings = \App\Models\Booking::where('route_id', $route->id)
                ->where('status', '!=', 'Cancelled')
                ->count();

            $this->info("ID: {$route->id} | Total Cap: {$totalCapacity} | Bookings: {$currentBookings}");
        }
    }
}
