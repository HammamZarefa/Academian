<?php

namespace App\Listeners;

use App\Events\NewOrderEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrder;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSummary;
use App\User;

class NewOrderListener
{
    /**
     * Handle the event.
     *
     * @param  NewOrderEvent  $event
     * @return void
     */
    public function handle(NewOrderEvent $event)
    {
        $order = $event->order;
        // Send Order Summary to Customer
        Mail::to($order->customer)->send(new OrderSummary($order));
        $admins = User::role('admin')->get();
        // Send notification to the followers
        Notification::send($admins, new NewOrder($order));
        // Send Notification Email to Admin/Company
        Notification::route('mail', company_notification_email())
            ->notify(new NewOrder($order));
    }
}
