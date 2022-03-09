<?php

namespace App\Listeners;

use App\Events\BillReceivedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewPaymentRequest;
use App\User;

class BillReceivedListener
{
    /**
     * Handle the event.
     *
     * @param  BillReceivedEvent  $event
     * @return void
     */
    public function handle(BillReceivedEvent $event)
    {
        $bill = $event->bill;

        // Log user's activity
        $subject = anchor($bill->number, route('bills_show', $bill->id));
        logActivity($bill, 'requested for payment ' . $subject);

        $admins = User::role('admin')->get();
        if ($admins->count() > 0) {
            Notification::send($admins, new NewPaymentRequest($bill));
        }
        Notification::route('mail', company_notification_email())
            ->notify(new NewPaymentRequest($bill));
    }
}
