<?php

namespace App\Enums\Config;

enum ServiceStatusEnum: string
{
    case IDEA = 'idea';
    case DEVELOP = 'develop';
    case PRODUCTION = 'production';
}
