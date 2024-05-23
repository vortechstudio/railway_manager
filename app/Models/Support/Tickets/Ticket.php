<?php

namespace App\Models\Support\Tickets;

use App\Enums\Support\Tickets\TicketPriorityEnum;
use App\Enums\Support\Tickets\TicketStatusEnum;
use App\Models\Config\Service;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\LaravelOptions\Options;

class Ticket extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'mysql';

    protected $casts = [
        'status' => TicketStatusEnum::class,
        'priority' => TicketPriorityEnum::class,
    ];

    protected $appends = [
        'priority_human',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function getPriorityHumanAttribute()
    {
        foreach (Options::forEnum(TicketPriorityEnum::class)->toArray() as $priority) {
            return match ($priority['value']) {
                'low' => 'Basse',
                'medium' => 'Moyenne',
                'high' => 'Haute'
            };
        }
    }
}
