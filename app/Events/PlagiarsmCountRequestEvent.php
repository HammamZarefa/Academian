<?php

namespace App\Events;

use App\OnlineServiceHistory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlagiarsmCountRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $plagiarism;
    public $user_id;
    public $service_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OnlineServiceHistory $plagiarism, $user_id, $service_id)
    {
        $this->plagiarism=$plagiarism;
        $this->user_id=$user_id;
        $this->service_id=$service_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
