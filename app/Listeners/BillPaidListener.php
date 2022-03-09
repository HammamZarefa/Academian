<?php

namespace App\Listeners;

use App\Events\BillPaidEvent;
use App\Notifications\PayoutProcessed;

class BillPaidListener
{
    /**
     * Handle the event.
     *
     * @param  BillPaidEvent  $event
     * @return void
     */
    public function handle(BillPaidEvent $event)
    {
        $event->bill->from->notify(new PayoutProcessed($event->bill));
    }
}
