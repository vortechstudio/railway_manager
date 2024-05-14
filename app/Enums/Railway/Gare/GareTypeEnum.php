<?php

namespace App\Enums\Railway\Gare;

enum GareTypeEnum: string
{
    case HALTE = 'halte';
    case SMALL = 'small';
    case MEDIUM = 'medium';
    case LARGE = 'large';
    case TERMINUS = 'terminus';
}
