<?php

namespace App\Enums\Railway\Engine;

enum RailwayEngineTransportEnum: string
{
    case TER = 'ter';
    case TGV = 'tgv';
    case INTERCITY = 'intercity';
    case TRAM = 'tram';
    case METRO = 'metro';
    case OTHER = 'other';
}
