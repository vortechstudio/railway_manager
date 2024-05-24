<?php

namespace App\Models\Railway\Planning;

use App\Enums\Railway\Users\RailwayPlanningStationStatusEnum;
use App\Models\Railway\Ligne\RailwayLigneStation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayPlanningStation extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'departure_at' => 'datetime',
        'arrival_at' => 'datetime',
        'status' => RailwayPlanningStationStatusEnum::class,
    ];

    public function railwayPlanning(): BelongsTo
    {
        return $this->belongsTo(RailwayPlanning::class, 'railway_planning_id');
    }

    public function railwayLigneStation(): BelongsTo
    {
        return $this->belongsTo(RailwayLigneStation::class, 'railway_ligne_station_id');
    }
}
