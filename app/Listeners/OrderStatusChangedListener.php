<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;

class OrderStatusChangedListener
{
    /**
     * Handle the event.
     *
     * @param  OrderStatusChangedEvent  $event
     * @return void
     */
    public function handle(OrderStatusChangedEvent $event)
    {
        $order = $event->order;
        $previousStatus = $event->previousStatus;
        $newStatus = $event->newStatus;

        $state = 'from '. $previousStatus . ' to '. $newStatus; 
         // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        logActivity($order, 'changed status of '. $subject. ' '. $state);
    }
}
