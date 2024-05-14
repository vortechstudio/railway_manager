<?php

namespace App\Enums\Railway\Engine;

enum RailwayEngineEnergyEnum: string
{
    case VAPEUR = 'vapeur';
    case DIESEL = 'diesel';
    case ELECTRIQUE = 'electrique';
    case HYBRIDE = 'hybride';
    case NONE = 'none';
}
