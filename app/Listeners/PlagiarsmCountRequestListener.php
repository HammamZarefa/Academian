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
        $id =$event->id;
        $this->createPlagiarismLog($data,$id);
    }

    protected function createPlagiarismLog($data,$id){
        $data->insert([
            'user_id' => $id ,
        ]);

    }
}
