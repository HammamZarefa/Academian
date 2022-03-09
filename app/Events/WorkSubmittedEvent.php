<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\SubmittedWork;


class WorkSubmittedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $submittedWork;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SubmittedWork $submittedWork)
    {
        $this->submittedWork    = $submittedWork;
    }
}
