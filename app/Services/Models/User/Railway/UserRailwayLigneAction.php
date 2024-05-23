<?php

namespace App\Services\Models\User\Railway;

use App\Models\User\Railway\UserRailwayLigne;
use App\Models\User\Railway\UserRailwayMouvement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserRailwayLigneAction
{
    public function __construct(private UserRailwayLigne $ligne)
    {
    }

    public function getCA(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_ligne_id', $this->ligne->id)
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

    public function simulateSelling()
    {
        return ($this->ligne->railwayLigne->price / 2) + $this->getResultat(now()->subDays(7), now());
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

        foreach ($this->ligne->tarifs()->whereBetween('date_tarif', [now()->startOfDay(), now()->endOfDay()])->get() as $item) {
            $offer += $item->offre;
        }

        return $offer;
    }

    private function calcSumAmount(?string $type, ?Carbon $from, ?Carbon $to)
    {
        return $this->ligne->mouvements()
            ->where('user_railway_ligne_id', $this->ligne->id)
            ->when($type, function (Builder $query) use ($type) {
                $query->where('type_mvm', $type);
            })
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }
}
