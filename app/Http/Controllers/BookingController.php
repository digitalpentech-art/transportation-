<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of available routes for booking.
     */
    public function index()
    {
        $routes = Route::with('vehicles')
            ->where('departure_time', '>', now())
            ->latest()
            ->get();
        return view('passenger.book', compact('routes'));
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
        ]);

        $user = Auth::user();

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $user) {
            $route = Route::with('vehicles')->lockForUpdate()->findOrFail($request->route_id);

            // 1. Check for duplicate booking
            $existingBooking = Booking::where('user_id', $user->id)
                ->where('route_id', $route->id)
                ->where('status', '!=', 'Cancelled')
                ->first();

            if ($existingBooking) {
                return back()->with('error', 'You have already booked this route.');
            }

            // 2. Check for capacity
            $totalCapacity = $route->vehicles->sum('capacity');
            $currentBookings = Booking::where('route_id', $route->id)
                ->where('status', '!=', 'Cancelled')
                ->where('status', '!=', 'Waiting')
                ->count();

            $status = 'Pending';
            $message = 'Your booking request has been submitted.';

            if ($currentBookings >= $totalCapacity) {
                $status = 'Waiting';
                $message = 'This route is fully booked. You have been added to the waiting list.';
            }

            Booking::create([
                'user_id' => $user->id,
                'route_id' => $request->route_id,
                'status' => $status,
                'booking_time' => now(),
            ]);

            return redirect()->route('passenger.history')->with('success', $message);
        });
    }

    /**
     * Display the user's booking history.
     */
    public function history()
    {
        $bookings = Auth::user()->bookings()->with('route')->latest()->get();
        return view('passenger.history', compact('bookings'));
    }
}
