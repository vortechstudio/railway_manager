<?php

namespace App\Enums\Railway\Gare;

enum HubStatusEnum: string
{
    case NULL = '';

    case BETA = 'beta';

    case PROD = 'production';
}
