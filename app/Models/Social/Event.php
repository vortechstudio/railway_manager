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
    protected $connection = 'mysql';

    public $timestamps = false;

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => EventStatusEnum::class,
        'type_event' => EventTypeEnum::class,
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'type_label',
        'status_label',
    ];

    public function cercles()
    {
        return $this->belongsToMany(Cercle::class, 'event_cercle', 'event_id', 'cercle_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'user_event', 'event_id', 'user_id');
    }

    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

    public function graphics()
    {
        return $this->hasMany(EventGraphic::class);
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type_event) {
            EventTypeEnum::POLL => '<span class="badge badge-primary"><i class="fa-solid fa-poll text-white me-2"></i> Sondage</span>',
            EventTypeEnum::GRAPHIC => '<span class="badge badge-warning"><i class="fa-solid fa-image text-white me-2"></i> Graphique</span>',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            EventStatusEnum::DRAFT => '<span class="badge badge-secondary"><i class="fa-solid fa-pencil text-white me-2"></i> Brouillon</span>',
            EventStatusEnum::PROGRESS => '<span class="badge badge-success"><i class="fa-solid fa-exchange-alt text-white me-2"></i> En cours...</span>',
            EventStatusEnum::SUBMITTING => '<span class="badge badge-primary"><i class="fa-solid fa-envelope text-white me-2"></i> Soumission en cours...</span>',
            EventStatusEnum::EVALUATION => '<span class="badge badge-info"><i class="fa-solid fa-envelope text-white me-2"></i> Evaluation en cours...</span>',
            EventStatusEnum::CLOSED => '<span class="badge badge-danger"><i class="fa-solid fa-check-circle text-white me-2"></i> Terminer</span>',
            EventStatusEnum::PUBLISHED => '<span class="badge badge-warning"><i class="fa-solid fa-network-wired text-white me-2"></i> Publier</span>',
        };
    }

    public function getStatus(string $type)
    {
        return match ($type) {
            'text' => match ($this->status) {
                EventStatusEnum::DRAFT => 'Brouillon',
                EventStatusEnum::PROGRESS => 'En cours...',
                EventStatusEnum::SUBMITTING => 'Soumission en cours...',
                EventStatusEnum::EVALUATION => 'Evaluation en cours...',
                EventStatusEnum::CLOSED => 'Terminer',
                EventStatusEnum::PUBLISHED => 'Publier',
            },
            'icon' => match ($this->status) {
                EventStatusEnum::DRAFT => 'fa-pencil',
                EventStatusEnum::PROGRESS => 'fa-exchange-alt',
                EventStatusEnum::SUBMITTING => 'fa-envelope',
                EventStatusEnum::EVALUATION => 'fa-envelope',
                EventStatusEnum::CLOSED => 'fa-check-circle',
                EventStatusEnum::PUBLISHED => 'fa-network-wired',
            },
            'color' => match ($this->status) {
                EventStatusEnum::DRAFT => 'secondary',
                EventStatusEnum::PROGRESS => 'success',
                EventStatusEnum::SUBMITTING => 'primary',
                EventStatusEnum::EVALUATION => 'info',
                EventStatusEnum::CLOSED => 'danger',
                EventStatusEnum::PUBLISHED => 'warning',
            },
            default => $this->status,
        };
    }

    public function getType(string $type)
    {
        return match ($type) {
            'text' => match ($this->type_event) {
                EventTypeEnum::POLL => 'Sondage',
                EventTypeEnum::GRAPHIC => 'Graphique',
            },
            'icon' => match ($this->type_event) {
                EventTypeEnum::POLL => 'fa-poll',
                EventTypeEnum::GRAPHIC => 'fa-image',
            },
            'color' => match ($this->type_event) {
                EventTypeEnum::POLL => 'primary',
                EventTypeEnum::GRAPHIC => 'warning',
            },
            default => $this->type_event,
        };
    }

    public function getImage(string $type): string
    {
        $type = match ($type) {
            'icon' => 'icon',
            'header' => 'header',
            'default' => 'default',
        };

        if (\Storage::exists('events/'.$this->id.'/'.$type.'.webp')) {
            return \Storage::url('events/'.$this->id.'/'.$type.'.webp');
        } else {
            return \Storage::url('events/'.$type.'_default.png');
        }
    }
}
