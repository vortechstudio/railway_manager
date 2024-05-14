<?php

namespace App\Enums\Railway\Ligne;

enum LigneTypeEnum: string
{
    case TER = 'ter';
    case TGV = 'tgv';
    case INTERCITY = 'intercity';
    case TRAM = 'tram';
    case TRANSILIEN = 'transilien';
    case METRO = 'metro';
    case OTHER = 'other';
}
