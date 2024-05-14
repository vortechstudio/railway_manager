<?php

namespace App\Enums\Support\Tickets;

enum TicketPriorityEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}
