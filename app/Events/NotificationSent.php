<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;



    public function __construct(public Notification $notification)
    {

    }

    public function broadcastOn()
    {
        return new PrivateChannel('notifications.' . $this->notification->receiver_id);
    }

    public function broadcastWith()
    {
       
        return [
            'id' => $this->notification->id,
            'message' => $this->notification->message,
            'sender_id' => $this->notification->sender_id,
            'receiver_id' => $this->notification->receiver_id,
          
            'created_at' => $this->notification->created_at->toDateTimeString(),
        ];
    }
}