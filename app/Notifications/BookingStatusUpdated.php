<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Booking Status Update')
            ->line('Your booking status has been updated to: ' . $this->booking->status)
            ->line('Route: ' . $this->booking->route->origin . ' to ' . $this->booking->route->destination)
            ->action('View My Bookings', route('passenger.history'))
            ->line('Thank you for using our transport service!');
    }
}
