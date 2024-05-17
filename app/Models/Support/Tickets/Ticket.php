<?php

namespace App\Models\Support\Tickets;

use App\Enums\Support\Tickets\TicketPriorityEnum;
use App\Enums\Support\Tickets\TicketStatusEnum;
use App\Models\Config\Service;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $connection = 'mysql';

    protected $casts = [
        'status' => TicketStatusEnum::class,
        'priority' => TicketPriorityEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class);
    }
}
