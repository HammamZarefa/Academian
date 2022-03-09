<?php

namespace App\Listeners;

use App\Events\DeliveryAcceptedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DeliveryComplete;

class DeliveryAcceptedListener
{
    /**
     * Handle the event.
     *
     * @param  DeliveryAccepted  $event
     * @return void
     */
    public function handle(DeliveryAcceptedEvent $event)
    {
        $order = $event->order;
        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        logActivity($order, 'accepted delivered item for ' . $subject);

        // Send notification to the followers
        $followers = $order->followers->push($order->assignee);
        Notification::send($followers, new DeliveryComplete($order));

        // Prepare email addresses for sending notifications      
        Notification::route('mail', company_notification_email())
            ->notify(new DeliveryComplete($order));
    }
}
