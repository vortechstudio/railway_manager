<?php

namespace App\Services\Models\User\Railway;

use App\Models\Railway\Config\RailwayFluxMarket;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\Railway\UserRailwayMouvement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserRailwayHubAction
{
    public function __construct(private UserRailwayHub $hub)
    {
    }

    public function getCA(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_hub_id', $this->hub->id)
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

    public function getCout(?Carbon $from = null, ?Carbon $to = null)
    {
        $electricite = $this->calcSumAmount('electricite', $from, $to);
        $gasoil = $this->calcSumAmount('gasoil', $from, $to);
        $taxe = $this->calcSumAmount('taxe', $from, $to);
        $m_engine = $this->calcSumAmount('maintenance_engine', $from, $to);
        $cout_trajet = $this->calcSumAmount('cout_trajet', $from, $to);

        $ca = $this->getCA($from, $to);
        $cout = $electricite + $gasoil + $taxe + $m_engine + $cout_trajet;

        return $ca - $cout;
    }

    public function getResultat(?Carbon $from = null, ?Carbon $to = null)
    {
        $ca = $this->getCA($from, $to);
        $cout = $this->getCout($from, $to);

        return $ca - $cout;
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

    public function getSumPassengers(string $type_passenger, ?Carbon $from = null, ?Carbon $to = null)
    {
        $type_passenger = $type_passenger ?? 'unique';

        $plannings = $this->hub->plannings()
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween('date_depart', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->get();

        return $this->countPassengersByType($plannings, $type_passenger);
    }

    public function getLigneKilometer()
    {
        $sum = 0;
        foreach ($this->hub->userRailwayLigne as $ligne) {
            $sum += $ligne->railwayLigne->distance;
        }

        return $sum;
    }

    public function getCountIncidents(?Carbon $from = null, ?Carbon $to = null)
    {
        return $this->hub->incidents()
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->count();
    }

    public function getAmountIncidents(?Carbon $from = null, ?Carbon $to = null)
    {
        return $this->hub->mouvements()
            ->where('type_mvm', 'incident')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getCountCanceledTravel(?Carbon $from = null, ?Carbon $to = null)
    {
        return $this->hub->plannings()
            ->where('status', 'canceled')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween('date_depart', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->count();
    }

    public function getActualFluctuation()
    {
        return RailwayFluxMarket::whereDate('date', Carbon::today())
            ->first()->flux_hub;
    }

    public function simulateSelling()
    {
        return ($this->hub->railwayHub->price_base / 2) + $this->getResultat(now()->subDays(7), now());
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

    private function calcSumAmount(?string $type, ?Carbon $from, ?Carbon $to)
    {
        return $this->hub->mouvements()
            ->where('user_railway_hub_id', $this->hub->id)
            ->when($type, function (Builder $query) use ($type) {
                $query->where('type_mvm', $type);
            })
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }
}
