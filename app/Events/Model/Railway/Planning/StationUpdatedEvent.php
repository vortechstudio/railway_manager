<?php

namespace App\Events\Model\Railway\Planning;

use App\Models\Railway\Planning\RailwayPlanningStation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StationUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public RailwayPlanningStation $station)
    {
        //
    }

    public function broadcastOn()
    {
        return ['planning-station'];
    }
}
