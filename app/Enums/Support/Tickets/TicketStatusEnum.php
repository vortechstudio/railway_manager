<?php

namespace App\Enums\Support\Tickets;

enum TicketStatusEnum: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case PENDING = 'pending';
}
