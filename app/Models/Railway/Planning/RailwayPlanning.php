<?php

namespace App\Models\Railway\Planning;

use App\Enums\Railway\Users\RailwayPlanningStatusEnum;
use App\Models\User\Railway\UserRailwayEngine;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\Railway\UserRailwayLigne;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayPlanning extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'date_depart' => 'timestamp',
        'date_arrived' => 'timestamp',
        'status' => RailwayPlanningStatusEnum::class,
    ];

    protected $appends = [
        'incident_niveau_max',
    ];

    public function userRailwayHub(): BelongsTo
    {
        return $this->belongsTo(UserRailwayHub::class, 'user_railway_hub_id');
    }

    public function userRailwayLigne(): BelongsTo
    {
        return $this->belongsTo(UserRailwayLigne::class, 'user_railway_ligne_id');
    }

    public function userRailwayEngine(): BelongsTo
    {
        return $this->belongsTo(UserRailwayEngine::class, 'user_railway_engine_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function travel()
    {
        return $this->hasOne(RailwayPlanningTravel::class);
    }

    public function passengers()
    {
        return $this->hasMany(RailwayPlanningPassenger::class);
    }

    public function logs()
    {
        return $this->hasMany(RailwayPlannningLog::class);
    }

    public function stations()
    {
        return $this->hasMany(RailwayPlanningStation::class);
    }

    public function incidents()
    {
        return $this->hasMany(RailwayIncident::class);
    }

    public function getIncidentNiveauMaxAttribute()
    {
        $levelMax = $this->incidents->max('niveau');
        if($levelMax == 0 || $levelMax == 1) {
            return 'low';
        } elseif($levelMax == 2) {
            return 'middle';
        } else {
            return 'critical';
        }
    }


}
