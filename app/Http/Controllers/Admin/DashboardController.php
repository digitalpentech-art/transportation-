<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Route;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'vehicles' => Vehicle::count(),
            'routes' => Route::count(),
            'bookings' => Booking::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
