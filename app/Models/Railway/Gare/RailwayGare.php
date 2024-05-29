<?php

namespace App\Models\Railway\Gare;

use App\Enums\Railway\Gare\GareTypeEnum;
use App\Models\Railway\Ligne\RailwayLigneStation;
use App\Services\Models\Railway\Gare\GareAction;
use Illuminate\Database\Eloquent\Model;

class RailwayGare extends Model
{
    public $timestamps = false;

    protected $connection = 'railway';

    protected $guarded = [];

    protected $casts = [
        'type' => GareTypeEnum::class,
    ];

    protected $appends = [
        'is_hub',
        'type_gare_string',
        'type_equipement_string',
        'abr',
        'passenger_first',
        'passenger_second',
        'nb_max_commerce',
        'nb_max_publicite',
        'nb_max_parking',
        'time_day_work',
    ];

    public function weather()
    {
        return $this->hasOne(RailwayGareWeather::class);
    }

    public function hub()
    {
        return $this->hasOne(RailwayHub::class);
    }

    public function stations()
    {
        return $this->hasMany(RailwayLigneStation::class);
    }

    public function getTypeGareStringAttribute(): string
    {
        return match ($this->type->value) {
            'halte' => 'Halte',
            'small' => 'Petite Gare',
            'medium' => 'Moyenne Gare',
            'large' => 'Grande Gare',
            'terminus' => 'Terminus'
        };
    }

    public function getIsHubAttribute(): bool
    {
        return $this->hub()->count() != 0;
    }

    public function getTypeEquipementIconAttribute($equipement): ?string
    {
        return match ($equipement) {
            'toilette' => 'fa-restroom',
            'info_sonore' => 'fa-volume-up',
            'info_visuel' => 'fa-eye',
            'ascenceurs' => 'fa-elevator',
            'escalator' => 'fa-stairs',
            'guichets' => 'fa-ticket',
            'boutique' => 'fa-shop',
            'restaurant' => 'fa-utensils',
            default => null,
        };
    }

    public function getTypeEquipementStringAttribute($equipement): ?string
    {
        return match ($equipement) {
            'toilette' => 'Toilette',
            'info_sonore' => 'Information Sonore',
            'info_visuel' => 'Information visuelle',
            'ascenceurs' => 'Ascenceurs',
            'escalator' => 'Escalateurs',
            'guichets' => 'Guichets',
            'boutique' => 'Boutique',
            'restaurant' => 'Restaurant',
            default => null,
        };
    }

    public function getAbrAttribute()
    {
        return \Str::limit(\Str::upper($this->name), 3, '');
    }

    public function getPassengerFirstAttribute()
    {
        return (new GareAction($this))->getSumFirstPassenger();
    }

    public function getPassengerSecondAttribute()
    {
        return (new GareAction($this))->getSumSecondPassenger();
    }

    public function getNbMaxCommerceAttribute()
    {
        return (new GareAction($this))->calcNbSlotCommerce();
    }

    public function getNbMaxPubliciteAttribute()
    {
        return (new GareAction($this))->calcNbSlotPublicite();
    }

    public function getNbMaxParkingAttribute()
    {
        return (new GareAction($this))->calcNbSlotParking();
    }

    public function getTimeDayWorkAttribute()
    {
        return (new GareAction($this))->calcTimeDayWork();
    }

    public function formatIsHub()
    {
        if ($this->getIsHubAttribute()) {
            return "<i class='fa-solid fa-check-circle fs-1 text-success'></i>";
        } else {
            return "<i class='fa-solid fa-xmark-circle fs-1 text-danger'></i>";
        }
    }
}
