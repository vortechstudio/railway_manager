<?php

namespace App\Enums\Railway\Users;

enum RailwayRentalStatusEnum: string
{
    case ACTIVE = 'active';
    case TERMINATED = 'terminated';
    case DEFAULT = 'default';
}
