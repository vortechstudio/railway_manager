<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Ligne\RailwayLigne;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

    private function calcSumAmount(?string $type, ?Carbon $from, ?Carbon $to)
    {
        return $this->mouvements()
            ->where('user_railway_ligne_id', $this->id)
            ->when($type, function (Builder $query) use ($type) {
                $query->where('type_mvm', $type);
            })
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getCA(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_ligne_id', $this->id)
            ->where('type_amount', 'revenue')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getBenefice(?Carbon $from = null, ?Carbon $to = null)
    {
        $billetterie = $this->calcSumAmount('billetterie', $from, $to);
        $rent_aux = $this->calcSumAmount('rent_trajet_aux', $from, $to);
        $cout = $this->calcSumAmount('cout_trajet', $from, $to);

        return ($billetterie + $rent_aux) - $cout;
    }

    public function getRatioPerformance()
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

    public function getActualOffreLigne()
    {
        $offer = 0;

        foreach ($this->tarifs()->whereBetween('date_tarif', [now()->startOfDay(), now()->endOfDay()])->get() as $item) {
            $offer += $item->offre;
        }

        return $offer;
    }
}
