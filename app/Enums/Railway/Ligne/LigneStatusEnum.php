<?php

namespace App\Enums\Railway\Ligne;

enum LigneStatusEnum: string
{
    case NULL = '';
    case BETA = 'beta';
    case PROD = 'production';
}
