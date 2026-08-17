<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin',
        'destination',
        'departure_time',
    ];

    /**
     * Get the bookings for the route.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the vehicles assigned to the route.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
