<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Ligne\RailwayLigne;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\User\User;
use App\Services\Models\User\Railway\UserRailwayLigneAction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayLigne extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'date_achat' => 'timestamp',
    ];

    protected $appends = [
        'ratio_performance',
    ];

    public function userRailwayHub(): BelongsTo
    {
        return $this->belongsTo(UserRailwayHub::class, 'user_railway_hub_id');
    }

    public function railwayLigne(): BelongsTo
    {
        return $this->belongsTo(RailwayLigne::class, 'railway_ligne_id');
    }

    public function userRailwayEngine(): BelongsTo
    {
        return $this->belongsTo(UserRailwayEngine::class, 'user_railway_engine_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tarifs()
    {
        return $this->hasMany(UserRailwayLigneTarif::class);
    }

    public function plannings()
    {
        return $this->hasMany(RailwayPlanning::class);
    }

    public function mouvements()
    {
        return $this->hasMany(UserRailwayMouvement::class);
    }

    public function getRatioPerformanceAttribute()
    {
        return (new UserRailwayLigneAction($this))->getRatioPerformance();
    }

    public function getCA(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayLigneAction($this))->getCA($from, $to);
    }

    public function getBenefice(?Carbon $from = null, ?Carbon $to = null)
    {
        return (new UserRailwayLigneAction($this))->getBenefice($from, $to);
    }

    public function getActualOffreLigne()
    {
        return (new UserRailwayLigneAction($this))->getActualOffreLigne();
    }

    public function simulateSelling()
    {
        return (new UserRailwayLigneAction($this))->simulateSelling();
    }
}
