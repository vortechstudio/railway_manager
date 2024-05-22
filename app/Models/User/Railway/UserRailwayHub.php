<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Gare\RailwayHub;
use App\Models\Railway\Planning\RailwayIncident;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\User\User;
use App\Services\Models\User\Railway\UserRailwayHubAction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayHub extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'date_achat' => 'timestamp',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function railwayHub(): BelongsTo
    {
        return $this->belongsTo(RailwayHub::class, 'railway_hub_id');
    }

    public function userRailwayLigne()
    {
        return $this->hasMany(UserRailwayLigne::class);
    }

    public function userRailwayEngine()
    {
        return $this->hasMany(UserRailwayEngine::class);
    }

    public function plannings()
    {
        return $this->hasMany(RailwayPlanning::class);
    }

    public function incidents()
    {
        return $this->hasMany(RailwayIncident::class);
    }

    public function mouvements()
    {
        return $this->hasMany(UserRailwayMouvement::class);
    }

    public function getCA(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayHubAction($this))->getCA($from, $to);
    }

    public function getBenefice(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayHubAction($this))->getBenefice($from, $to);
    }

    public function getFraisCarburant(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayHubAction($this))->getFraisCarburant($from, $to);
    }

    public function getFraisElectrique(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayHubAction($this))->getFraisElectrique($from, $to);
    }

    public function getTaxe(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayHubAction($this))->getTaxe($from, $to);
    }

    public function getRatioPerformance(): string
    {
        $yesteday_result = $this->getBenefice(now()->subDays(), now()->subDays());
        $ref_result = $this->getBenefice(now()->subDays(2), now()->subDays(2));

        if ($yesteday_result > $ref_result) {
            return "<i class='fa-solid fa-arrow-up text-success fs-2 me-3'></i>";
        } elseif ($yesteday_result == $ref_result) {
            return "<i class='fa-solid fa-arrow-right text-warning fs-2 me-3'></i>";
        } else {
            return "<i class='fa-solid fa-arrow-down text-danger fs-2 me-3'></i>";
        }
    }

    public function getSumPassengers(string $type_passenger, ?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayHubAction($this))->getSumPassengers($type_passenger, $from, $to);
    }

    public function getLigneKilometer()
    {
        return (new UserRailwayHubAction($this))->getLigneKilometer();
    }

    public function getCountIncidents(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayHubAction($this))->getCountIncidents($from, $to);
    }

    public function getAmountIncident(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayHubAction($this))->getAmountIncidents($from, $to);
    }

    public function getCountCanceledTravel(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayHubAction($this))->getCountCanceledTravel($from, $to);
    }
}
