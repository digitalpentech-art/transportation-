<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('bookings.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
