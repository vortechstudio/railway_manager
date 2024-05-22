<?php

namespace App\Enums\Railway\Users;

enum RailwayEngineStatusEnum: string
{
    case FREE = 'free';
    case IN_DELIVERY = 'in_delivery';
    case IN_MAINTENANCE = 'in_maintenance';
    case TRAVEL = 'travel';
    case NOFREE = 'nofree';

}
