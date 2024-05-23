<?php

namespace App\Enums\Railway\Users;

enum RailwayDeliveryTypeEnum: string
{
    case HUB = 'hub';
    case LIGNE = 'ligne';
    case ENGINE = 'engine';
    case RESEARCH = 'research';
}
