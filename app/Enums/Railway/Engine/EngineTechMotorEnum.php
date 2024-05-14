<?php

namespace App\Enums\Railway\Engine;

enum EngineTechMotorEnum: string
{
    case DIESEL = 'diesel';
    case ELEC_1500 = 'electrique 1500v';
    case ELEC_25 = 'electrique 25Kv';
    case ELEC_DUAL = 'electrique 1500v/25Kv';
    case HYBRIDE = 'hybride';
    case VAPEUR = 'vapeur';
    case AUTRE = 'autre';
}
