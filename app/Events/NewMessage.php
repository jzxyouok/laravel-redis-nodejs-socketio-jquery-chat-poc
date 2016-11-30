<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $chat;
    public $user;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\User $user, \App\Chat $chat, \App\Message $message)
    {
        $this->user = $user;
        $this->chat = $chat;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat.'.$this->chat->id);
    }
}
