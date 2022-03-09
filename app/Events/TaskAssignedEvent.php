<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\Order;

class TaskAssignedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $assigned_by;
    public $assigned_to;
    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $assigned_by, Order $order)
    {
        $this->assigned_by      = $assigned_by;
        $this->assigned_to      = $order->assignee;
        $this->order            = $order;
    }

   
}
