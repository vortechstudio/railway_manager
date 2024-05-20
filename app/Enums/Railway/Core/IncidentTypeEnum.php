<?php

namespace App\Enums\Railway\Core;

enum IncidentTypeEnum: string
{
    case MATERIEL = 'materiel';
    case INFRASTRUCTURE = 'infrastructure';
    case HUMAIN = 'humain';
}
