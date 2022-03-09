<?php

namespace App\Listeners;

use App\Events\WorkSubmittedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WorkSubmitted;

class WorkSubmittedListener
{
    /**
     * Handle the event.
     *
     * @param  WorkSubmittedEvent  $event
     * @return void
     */
    public function handle(WorkSubmittedEvent $event)
    {
        $order  = $event->submittedWork->order;
        $submittedWork = $event->submittedWork;
        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        logActivity($order, 'submitted work for ' . $subject);

        // Send notification to the followers
        Notification::send($order->followers, new WorkSubmitted($submittedWork));

        $emails = [company_notification_email(), $order->customer->email];

        foreach ($emails as $email) {
            Notification::route('mail', $email)->notify(new WorkSubmitted($submittedWork));
        }
    }
}
