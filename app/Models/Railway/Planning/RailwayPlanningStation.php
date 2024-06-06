<?php

namespace App\Models\Railway\Planning;

use App\Enums\Railway\Users\RailwayPlanningStationStatusEnum;
use App\Events\Model\Railway\Planning\StationUpdatedEvent;
use App\Models\Railway\Ligne\RailwayLigneStation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperRailwayPlanningStation
 */
class RailwayPlanningStation extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    protected $dispatchesEvents = [
        'updated' => StationUpdatedEvent::class,
    ];

    protected $casts = [
        'departure_at' => 'datetime',
        'arrival_at' => 'datetime',
        'status' => RailwayPlanningStationStatusEnum::class,
    ];

    protected $appends = [
        'status_label',
    ];

    public function railwayPlanning(): BelongsTo
    {
        return $this->belongsTo(RailwayPlanning::class, 'railway_planning_id');
    }

    public function railwayLigneStation(): BelongsTo
    {
        return $this->belongsTo(RailwayLigneStation::class, 'railway_ligne_station_id');
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status->value) {
            'init' => '<span class="badge badge-secondary">Préparer</span>',
            'departure' => '<span class="badge badge-primary animate__animated animate__flash animate__infinite">Départ en cours...</span>',
            'arrival' => '<span class="badge badge-danger animate__animated animate__flash animate__infinite">En approche</span>',
            'done' => '<span class="badge badge-success">Arret effectuer</span>',
        };
    }
}
