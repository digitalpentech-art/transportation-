<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'route'])->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }
}
