<?php

namespace App\Models\Railway\Engine;

use App\Enums\Railway\Engine\RailwayEngineEnergyEnum;
use App\Enums\Railway\Engine\RailwayEngineStatusEnum;
use App\Enums\Railway\Engine\RailwayEngineTrainEnum;
use App\Enums\Railway\Engine\RailwayEngineTransportEnum;
use App\Models\Railway\Config\RailwayRental;
use App\Models\User\Railway\UserRailwayEngine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RailwayEngine extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
        'type_transport' => RailwayEngineTransportEnum::class,
        'type_train' => RailwayEngineTrainEnum::class,
        'type_energy' => RailwayEngineEnergyEnum::class,
        'status' => RailwayEngineStatusEnum::class,
        'duration_maintenance' => 'datetime',
    ];

    protected $appends = [
        'slug',
    ];

    public function shop()
    {
        return $this->hasOne(RailwayEngineShop::class);
    }

    public function price()
    {
        return $this->hasOne(RailwayEnginePrice::class);
    }

    public function technical()
    {
        return $this->hasOne(RailwayEngineTechnical::class);
    }

    public function rentals()
    {
        return $this->belongsToMany(RailwayRental::class, 'railway_engine_rentals');
    }

    public function users()
    {
        return $this->hasMany(UserRailwayEngine::class);
    }

    public function getSlugAttribute()
    {
        return \Str::slug($this->name);
    }

    public function getFirstImage($engine_id)
    {
        $engine = self::find($engine_id);

        if ($engine->type_train == RailwayEngineTrainEnum::AUTO) {
            return \Storage::url('engines/automotrice/'.\Str::slug($engine->name).'-0.gif');
        } else {
            return \Storage::url('engines/'.$engine->type_train->value.'/'.\Str::slug($engine->name).'.gif');
        }
    }

    public function statusFormat(string $format)
    {
        return match ($format) {
            'text' => match ($this->status->value) {
                'beta' => 'BETA',
                'production' => 'PRODUCTION',
            },
            'color' => match ($this->status->value) {
                'beta' => 'warning',
                'production' => 'success',
            },
            'icon' => match ($this->status->value) {
                'beta' => 'flask',
                'production' => 'check',
            }
        };
    }

    public function inGameFormat(string $format)
    {
        return match ($format) {
            'text' => $this->in_game ? 'Disponible' : 'Indisponible',
            'color' => $this->in_game ? 'success' : 'danger',
            'icon' => $this->in_game ? 'check' : 'times',
        };
    }

    public function inShopFormat(string $format)
    {
        return match ($format) {
            'text' => $this->in_shop ? 'Disponible' : 'Indisponible',
            'color' => $this->in_shop ? 'success' : 'danger',
            'icon' => $this->in_shop ? 'check' : 'times',
        };
    }
}
