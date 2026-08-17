<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type',
        'driver_id',
        'route_id',
        'capacity',
    ];

    /**
     * Get the route assigned to the vehicle.
     */
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * Get the driver (user) that owns the vehicle.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
