<?php

namespace App\Listeners;

use App\Events\PlagiarsmCountRequestEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PlagiarsmCountRequestListener
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
     * @param PlagiarsmCountRequestEvent $event
     * @return void
     */
    public function handle(PlagiarsmCountRequestEvent $event)
    {
        $data=$event->plagiarism;
        $user_id =$event->user_id;
        $service_id =$event->service_id;
        $this->createPlagiarismLog($data,$user_id,$service_id);
    }

    protected function createPlagiarismLog($data,$user_id,$service_id){
        $data->insert([
            'user_id' => $user_id ,
            'service_id' => $service_id ,
        ]);

    }
}
