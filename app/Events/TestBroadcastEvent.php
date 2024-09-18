<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestBroadcastEvent implements ShouldBroadcast
{
    public function broadcastOn()
    {
        return new Channel('test-channel');
    }

    public function broadcastWith()
    {
        return ['message' => 'Hello, this is a test message!'];
    }
}