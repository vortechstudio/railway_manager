<?php

namespace App\Enums\Railway\Config;

enum BonusTypeEnum: string
{
    case ARGENT = 'argent';
    case TPOINT = 'tpoint';
    case RESEARCH = 'research';
    case SIMULATION = 'simulation';
    case AUDIT = 'audit_int';
}
