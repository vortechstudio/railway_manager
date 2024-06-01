<?php

namespace App\Services\Models\User\Railway;

use App\Models\User\Railway\UserRailwayCompany;
use App\Models\User\Railway\UserRailwayMouvement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserRailwayCompanyAction
{
    public function __construct(private UserRailwayCompany $company)
    {
    }

    public function getCA(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_amount', 'revenue')
            ->whereNot('type_mvm', 'divers')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getCoastTravel(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'cout_trajet')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getResultat(?Carbon $from = null, ?Carbon $to = null)
    {
        $ca = $this->getCA($from, $to);
        $charge = $this->getCoastTravel($from, $to);

        return $ca - $charge;
    }

    public function getRembEmprunt(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'pret')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getLocationMateriel(?Carbon $from = null, ?Carbon $to = null)
    {
        return UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'location_materiel')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
    }

    public function getTresorerieStructurel(?Carbon $from = null, ?Carbon $to = null)
    {
        $maintenance = UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'maintenance_engine')
            ->orWhere('type_mvm', 'maintenance_technicentre')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');

        $location = $this->getLocationMateriel($from, $to);
        $rembEmprunt = $this->getRembEmprunt($from, $to);
        $impot = UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'impot')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
        $revenue = UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_amount', 'revenue')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');

        return $revenue - ($maintenance + $location + $rembEmprunt + $impot);
    }

    public function getBenefice(?Carbon $from = null, ?Carbon $to = null)
    {
        $billetterie = UserRailwayMouvement::where('user_railway_company_id', $this->company->id)
            ->where('type_mvm', 'billetterie')
            ->when($from && $to, function (Builder $query) use ($from, $to) {
                return $query->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()]);
            })
            ->sum('amount');
        $cout = $this->getCoastTravel($from, $to);

        return $billetterie - $cout;
    }
}
