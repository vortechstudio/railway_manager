<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Gare\RailwayHub;
use App\Models\Railway\Planning\RailwayIncident;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

    private function calcSumAmount(?string $type, ?Carbon $from, ?Carbon $to)
    {
        return $this->mouvements()
            ->where('user_railway_hub_id', $this->id)
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
        return UserRailwayMouvement::where('user_railway_hub_id', $this->id)
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

    public function getFraisCarburant(?Carbon $from = null, ?Carbon $to = null)
    {
        return $this->calcSumAmount('gasoil', $from, $to);
    }

    public function getFraisElectrique(?Carbon $from = null, ?Carbon $to = null)
    {
        return $this->calcSumAmount('electrique', $from, $to);
    }

    public function getTaxe(?Carbon $from = null, ?Carbon $to = null)
    {
        return $this->calcSumAmount('taxe', $from, $to);
    }

    public function getRatioPerformance()
    {
        $yesteday_result = $this->getBenefice(now()->subDays(), now()->subDays());
        $ref_result = $this->getBenefice(now()->subDays(2), now()->subDays(2));

        if ($yesteday_result > $ref_result) {
            return "<i class='fa-solid fa-circle-arrow-up text-green-600 fs-2 me-5'></i>";
        } elseif ($yesteday_result == $ref_result) {
            return "<i class='fa-solid fa-circle-arrow-right text-orange-600 fs-2 me-5'></i>";
        } else {
            return "<i class='fa-solid fa-circle-arrow-down text-red-600 fs-2 me-5'></i>";
        }
    }

    public function getSumPassengers(string $type_passenger, ?Carbon $from = null, ?Carbon $to = null)
    {
        $type_passenger = $type_passenger ?? 'unique';

        $plannings = $this->plannings()
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween('date_depart', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->get();

        return $this->countPassengersByType($plannings, $type_passenger);
    }

    private function countPassengersByType($plannings, $type_passager)
    {
        $sum = 0;
        foreach ($plannings as $planning) {
            $sum += $planning->passengers()
                ->where('type', $type_passager)
                ->sum('nb_passengers');
        }

        return $sum;
    }
}
