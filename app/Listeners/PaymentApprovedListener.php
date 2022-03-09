<?php

namespace App\Listeners;

use App\Events\PaymentApprovedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentApproved;

class PaymentApprovedListener
{
    /**
     * Handle the event.
     *
     * @param  PaymentApprovedEvent  $event
     * @return void
     */
    public function handle(PaymentApprovedEvent $event)
    {
        $payment = $event->payment;
        // Log user's activity    
        logActivity($payment, 'approved an offline payment');
        // Send notification to the client
        Notification::send($payment->from, new PaymentApproved($payment));
    }
}
