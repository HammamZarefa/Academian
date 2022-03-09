<?php

namespace App\Listeners;

use App\Events\TaskAssignedEvent;
use App\Notifications\TaskAssigned;
use App\Follower;

class TaskAssignedListener
{
    /**
     * Handle the event.
     *
     * @param  TaskAssignedEvent  $event
     * @return void
     */
    public function handle(TaskAssignedEvent $event)
    {
        $order = $event->order;
        $assigned_to = $event->assigned_to;

        // Add the assigner as a follower
        Follower::firstOrCreate([
            'order_id' => $order->id,
            'user_id' => $event->assigned_by->id
        ]);

        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        $to = anchor($assigned_to->full_name, route('user_profile', $assigned_to->id));
        logActivity($order, 'assigned ' . $subject . ' to ' . $to);

        // Send notification to assignee
        $assigned_to->notify((new TaskAssigned($event->assigned_by, $order)));
    }
}
