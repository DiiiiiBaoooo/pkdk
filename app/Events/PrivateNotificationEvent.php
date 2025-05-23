<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrivateNotificationEvent implements ShouldBroadcastNow    
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
public $user_id;
public $message;
// cập nhật số lượng tin nhắn chưa đọc
public $unread_messages;
    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $message, $unread_messages)
    {
        //
        $this->user_id = $user_id;
        $this->message = $message;
        $this->unread_messages = $unread_messages;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('users.' . $this->user_id),
        ];
    }
    public function broadcastWith()
    {
        return [
         
            'message' => $this->message,
            'user_id' => $this->user_id,
            'unread_messages' => $this->unread_messages,
        
        ];
    }
}
