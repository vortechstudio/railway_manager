<?php

namespace App\Enums\Railway\Users;

enum RailwayTechnicentreStatusEnum: string
{
    case PLANIFIED = 'planified';
    case PROGRESSED = 'progressed';
    case FINISHED = 'finished';
    case CANCELLED = 'cancelled';
}
