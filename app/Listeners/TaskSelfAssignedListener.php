<?php

namespace App\Listeners;

use App\Events\TaskSelfAssignedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SelfAssignedTask;
use App\User;

class TaskSelfAssignedListener
{
    /**
     * Handle the event.
     *
     * @param  TaskSelfAssignedEvent  $event
     * @return void
     */
    public function handle(TaskSelfAssignedEvent $event)
    {
        $order = $event->order;

        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        logActivity($order, 'self assigned ' . $subject);

        $admins = User::role('admin')->get();

        // Send notification to the followers
        Notification::send($admins, new SelfAssignedTask($order, $event->user));

        Notification::route('mail', company_notification_email())
            ->notify(new SelfAssignedTask($order, $event->user));
    }
}
