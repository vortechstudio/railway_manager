<?php

namespace App\Enums\Railway\Users;

enum RailwayPlanningStatusEnum: string
{
    case INIT = 'initialized';
    case DEPART = 'departure';
    case TRAVEL = 'travel';
    case IN_STATION = 'in_station';
    case ARRIVAL = 'arrival';
    case RETARDED = 'retarded';
    case CANCELED = 'canceled';
}
