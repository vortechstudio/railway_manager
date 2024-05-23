<?php

namespace App\Enums\Railway\Users;

enum RailwayPlanningStationStatusEnum: string
{
    case INIT = 'init';
    case DEPARTURE = 'departure';
    case ARRIVAL = 'arrival';
    case DONE = 'done';
}
