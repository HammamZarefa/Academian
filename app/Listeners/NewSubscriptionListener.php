<?php

namespace App\Listeners;

use App\Events\NewSubscriptionEvent;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewSubscriptionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewSubscriptionEvent $event)
    {
        $data=$event->subscription;
        $service_id =$event->service_id;
        $user_id =$event->user_id;
        $this->createSubscriptionLog($data,$service_id,$user_id);
    }

    protected function createSubscriptionLog($data,$service_id,$user_id){
        $current_date=Carbon::now();
        $data->insert([
            'online_service_id' => $service_id ,
            'user_id' => $user_id ,
            'activity' => 1 ,
            'start_data' => $current_date
        ]);

    }
}
