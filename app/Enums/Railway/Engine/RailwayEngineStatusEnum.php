<?php

namespace App\Enums\Railway\Engine;

enum RailwayEngineStatusEnum: string
{
    case NULL = '';
    case BETA = 'beta';
    case PROD = 'production';
}
