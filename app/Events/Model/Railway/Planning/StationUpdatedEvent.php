<?php

namespace App\Events\Model\Railway\Planning;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StationUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public int $stationId)
    {
        //
    }

    public function broadcastOn()
    {
        return ['planning-station'];
    }
}
