<?php

namespace App\Listeners;

use App\Events\RequestedForRevisionEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ClientRequestedForRevision;

class RequestedForRevisionListener
{
    /**
     * Handle the event.
     *
     * @param  RequestedForRevisionEvent  $event
     * @return void
     */
    public function handle(RequestedForRevisionEvent $event)
    {
        $order = $event->order;

        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        logActivity($order, 'requested for revision ' . $subject);

        $followers = $order->followers->push($order->assignee);
        Notification::send($followers, new ClientRequestedForRevision($order));

        Notification::route('mail', company_notification_email())
            ->notify(new ClientRequestedForRevision($order));
    }
}
