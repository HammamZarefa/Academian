<?php

namespace App\Listeners;

use App\Events\PaymentDisapprovedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentDisapproved;
use App\User;

class PaymentDisapprovedListener
{
    /**
     * Handle the event.
     *
     * @param  PaymentDisapprovedEvent  $event
     * @return void
     */
    public function handle(PaymentDisapprovedEvent $event)
    {
        $data = $event->data;   
        // Log user's activity    
        logActivity(null, 'disapproved an offline payment', null, $data);
        // Send notification to the client
        $paymentFrom = User::find($data['user_id']);
        Notification::send($paymentFrom, new PaymentDisapproved($data));
    }
}
