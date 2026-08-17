<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    /**
     * Display the driver's dashboard and assigned bookings.
     */
    public function index()
    {
        $user = Auth::user()->load('vehicle');
        $vehicle = $user->vehicle;

        if (!$vehicle || !$vehicle->route_id) {
            return view('driver.dashboard', ['bookings' => collect(), 'vehicle' => $vehicle]);
        }

        $bookings = Booking::where('route_id', $vehicle->route_id)
            ->with(['user', 'route'])
            ->latest()
            ->get();

        return view('driver.dashboard', compact('bookings', 'vehicle'));
    }

    /**
     * Update the status of a booking.
     */
    public function updateStatus(Request $request, $booking)
    {
        // Handle both route model binding and raw ID (useful for tests)
        if (!$booking instanceof Booking) {
            $booking = Booking::findOrFail($booking);
        }

        $request->validate([
            'status' => 'required|in:Confirmed,Completed,Cancelled',
        ]);

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $booking) {
            $oldStatus = $booking->status;
            $booking->update(['status' => $request->status]);

            // If a booking was cancelled and it was previously occupying a seat,
            // check if there's someone on the waiting list to promote.
            if ($request->status === 'Cancelled' && in_array($oldStatus, ['Pending', 'Confirmed'])) {
                $this->promoteFromWaitingList($booking->route_id);
            }

            // Send notification
            if ($booking->user) {
                $booking->user->notify(new \App\Notifications\BookingStatusUpdated($booking));
                event(new \App\Events\BookingStatusUpdatedEvent($booking));
            }

            return back()->with('success', 'Booking status updated successfully and passenger notified.');
        });
    }

    /**
     * Promote the next passenger in line from the waiting list.
     */
    protected function promoteFromWaitingList($routeId)
    {
        $nextInLine = Booking::with('user')->where('route_id', $routeId)
            ->where('status', 'Waiting')
            ->orderBy('booking_time', 'asc')
            ->first();

        if ($nextInLine && $nextInLine->user) {
            $nextInLine->update(['status' => 'Pending']);
            // Notify the passenger that they have been promoted from the waiting list
            $nextInLine->user->notify(new \App\Notifications\BookingStatusUpdated($nextInLine));
        }
    }
}
