<?php

namespace App\Models\Social;

use App\Enums\Social\EventStatusEnum;
use App\Enums\Social\EventTypeEnum;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Taggable\Traits\Taggable;

class Event extends Model
{
    use Taggable;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'start_at' => 'timestamp',
        'end_at' => 'timestamp',
        'status' => EventStatusEnum::class,
        'type_event' => EventTypeEnum::class,
    ];

    public function cercles()
    {
        return $this->belongsToMany(Cercle::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'user_event', 'event_id', 'user_id');
    }

    public function poll()
    {
        return $this->hasOne(Poll::class);
    }
}
