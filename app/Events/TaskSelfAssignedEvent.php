<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Order;
use App\User;

class TaskSelfAssignedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order, User $user)
    {
        $this->order    = $order;
        $this->user     = $user;
    }

    
}
