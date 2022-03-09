<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;

class NotificationSentListener
{
    /**
     * Handle the event.
     *
     * @param  NotificationSent  $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        if($event->channel == 'database' && isset($event->notifiable->id))
        {
            pushNotification($event->notifiable->id);
        }
       
    }
}
