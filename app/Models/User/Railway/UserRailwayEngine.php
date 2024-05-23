<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Users\RailwayEngineStatusEnum;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\Railway\Planning\RailwayIncident;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\Railway\Planning\RailwayPlanningConstructor;
use App\Models\User\User;
use App\Services\Models\User\Railway\UserRailwayEngineAction;
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

    protected $appends = [
        'status_badge',
        'utilisation',
        'resultat',
        'actual_usure',
        'indice_ancien',
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

    public function userRailwayHub()
    {
        return $this->belongsTo(UserRailwayHub::class, 'user_railway_hub_id');
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

    public function getStatusBadgeAttribute()
    {
        $icon = (new UserRailwayEngineAction($this))->getStatusFormat('icon');
        $color = (new UserRailwayEngineAction($this))->getStatusFormat('color');
        $text = (new UserRailwayEngineAction($this))->getStatusFormat();

        return "<span class='badge badge-sm bg-{$color}-500'><i class='{$icon} text-white me-2'></i> {$text}</span>";
    }

    public function getUtilisationAttribute()
    {
        return (new UserRailwayEngineAction($this))->getUsedRuntimeEngine();
    }

    public function getResultatAttribute()
    {
        return (new UserRailwayEngineAction($this))->getResultat();
    }

    public function getActualUsureAttribute()
    {
        return (new UserRailwayEngineAction($this))->getTotalUsure();
    }

    public function getIndiceAncienAttribute()
    {
        return (new UserRailwayEngineAction($this))->getIndiceAncien();
    }

    public function simulateSelling()
    {
        return (new UserRailwayEngineAction($this))->simulateSelling();
    }
}
