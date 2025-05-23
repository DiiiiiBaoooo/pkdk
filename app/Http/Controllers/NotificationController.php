<?php

namespace App\Http\Controllers;

use App\Events\NotificationSent;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $notification = Notification::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        // Phát sự kiện realtime
        broadcast(new NotificationSent($notification));
        return response()->json(['status' => 'Notification sent']);
    }
}
