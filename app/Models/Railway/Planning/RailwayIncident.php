<?php

namespace App\Models\Railway\Planning;

use App\Enums\Railway\Core\IncidentTypeEnum;
use App\Models\User\Railway\UserRailwayEngine;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayIncident extends Model
{
    protected $guarded = [];
    protected $connection = 'railway';
    protected $casts = [
        'type_incident' => IncidentTypeEnum::class,
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function railwayPlanning(): BelongsTo
    {
        return $this->belongsTo(RailwayPlanning::class, 'railway_planning_id');
    }

    public function userRailwayEngine(): BelongsTo
    {
        return $this->belongsTo(UserRailwayEngine::class, 'user_railway_engine_id');
    }

    public function userRailwayHub(): BelongsTo
    {
        return $this->belongsTo(UserRailwayHub::class, 'user_railway_hub_id');
    }
}
