<?php

namespace App\Enums\Railway\Config;

enum RailwayEmpruntTableStatusEnum: string
{
    case PLANNED = "planned";
    case PENDING = "pending";
    case PAID = "paid";
    case ERROR = "error";
}
