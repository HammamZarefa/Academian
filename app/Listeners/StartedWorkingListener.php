<?php

namespace App\Listeners;

use App\Events\StartedWorkingEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StartedWorking;

class StartedWorkingListener
{
    /**
     * Handle the event.
     *
     * @param  StartedWorkingEvent  $event
     * @return void
     */
    public function handle(StartedWorkingEvent $event)
    {
        $order = $event->order;

        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        logActivity($order, 'started working on ' . $subject);

        // Send notification to the followers
        Notification::send($order->followers, new StartedWorking($order));

        // Send notification to the company notification email
        Notification::route('mail', company_notification_email())
            ->notify(new StartedWorking($order));
    }
}
