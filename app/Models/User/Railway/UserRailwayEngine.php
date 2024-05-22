<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Users\RailwayEngineStatusEnum;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\Railway\Planning\RailwayIncident;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\Railway\Planning\RailwayPlanningConstructor;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayEngine extends Model
{
    public $timestamps = false;

    protected $connection = 'railway';

    protected $casts = [
        'date_achat' => 'timestamp',
        'status' => RailwayEngineStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function railwayEngine(): BelongsTo
    {
        return $this->belongsTo(RailwayEngine::class);
    }

    public function userRailwayLigne()
    {
        return $this->hasMany(UserRailwayLigne::class);
    }

    public function plannings()
    {
        return $this->hasMany(RailwayPlanning::class);
    }

    public function constructors()
    {
        return $this->hasMany(RailwayPlanningConstructor::class);
    }

    public function incidents()
    {
        return $this->hasMany(RailwayIncident::class);
    }
}
