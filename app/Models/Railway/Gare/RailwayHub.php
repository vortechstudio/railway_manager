<?php

namespace App\Models\Railway\Gare;

use App\Enums\Railway\Gare\HubStatusEnum;
use App\Models\Railway\Ligne\RailwayLigne;
use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Settings\Traits\Settingable;

class RailwayHub extends Model
{
    use Settingable;

    protected $guarded = [];
    protected $connection = 'railway';

    public $timestamps = false;

    protected $casts = [
        'status' => HubStatusEnum::class,
    ];

    protected $appends = [
        'is_active_label',
    ];

    public function gare()
    {
        return $this->belongsTo(RailwayGare::class, 'railway_gare_id');
    }

    public function lignes()
    {
        return $this->hasMany(RailwayLigne::class);
    }

    public function getIsActiveLabelAttribute()
    {
        if ($this->active) {
            return "<span class='badge badge-sm badge-success'><i class='fa-solid fa-check-circle text-white me-2'></i> Hub Actif</span>";
        } else {
            return "<span class='badge badge-sm badge-danger'><i class='fa-solid fa-xmark-circle text-white me-2'></i> Hub Inactif</span>";
        }
    }
}
