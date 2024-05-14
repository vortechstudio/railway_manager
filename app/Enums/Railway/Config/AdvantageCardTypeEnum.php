<?php

namespace App\Enums\Railway\Config;

enum AdvantageCardTypeEnum: string
{
    case ARGENT = 'argent';
    case RD_RATE = 'research_rate';
    case RD_COAST = 'research_coast';
    case AUDIT_INT = 'audit_int';
    case AUDIT_EXT = 'audit_ext';
    case SIMULATION = 'simulation';
    case IMPOT = 'credit_impot';
    case ENGINE = 'engine';
    case ENGINE_R = 'reskin';
}
