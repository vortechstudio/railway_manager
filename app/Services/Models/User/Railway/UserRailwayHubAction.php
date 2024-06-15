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
            ->where(function (Builder $query) {
                $query->where('type_mvm', 'billetterie')
                    ->orWhere('type_mvm', 'rent_trajet_aux');
            })
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
        $taxe = $this->calcSumAmount('taxe', $from, $to);

        $total_rent = $billetterie + $rent_aux;
        $total_cout = $cout + $taxe;

        return $total_rent - $total_cout;
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

    public function getLevelingHubCoef(string $system)
    {
        return match ($system) {
            'ligne_limit' => 15,
            'commerce' => 12,
            'publicity' => 10,
            'parking' => 19
        };
    }

    public function getNextLevelStatus(string $status)
    {
        return match ($status) {
            'ligne_limit' => $this->hub->ligne_limit + ($this->hub->ligne_limit * $this->getLevelingHubCoef('ligne_limit') / 100),
            'commerce' => $this->hub->commerce_limit + ($this->hub->commerce_limit * $this->getLevelingHubCoef('commerce') / 100),
            'publicity' => $this->hub->publicity_limit + ($this->hub->publicity_limit * $this->getLevelingHubCoef('publicity') / 100),
            'parking' => $this->hub->parking_limit + ($this->hub->parking_limit * $this->getLevelingHubCoef('parking') / 100),
        };
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
            ->when($type, function (Builder $query) use ($type) {
                $query->where('type_mvm', $type);
            })
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }
}
