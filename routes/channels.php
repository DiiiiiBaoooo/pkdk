<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('chat.{id}', function ($user, $id) {
    return true; // Allow all authenticated users to access the channel
});
Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    return (int) $user->user_id === (int) $userId;
});
Broadcast::channel('users.{userId}', function ($user, $userId) {
    return (int) $user->user_id === (int) $userId;
});
