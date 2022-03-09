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

class OrderStatusChangedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $previousStatus;
    public $newStatus;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order, $previousStatus, $newStatus)
    {
        $this->order                = $order;
        $this->previousStatus       = $previousStatus;
        $this->newStatus            = $newStatus;
    }
}
