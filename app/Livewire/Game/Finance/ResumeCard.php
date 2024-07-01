<?php

namespace App\Livewire\Game\Finance;

use App\Services\Models\User\Railway\UserRailwayCompanyAction;
use App\Services\Models\User\Railway\UserRailwayLigneAction;
use Livewire\Component;

class ResumeCard extends Component
{
    public int|float $benefice_ligne;
    public int|float $tresorerie_structurel;
    public int|float $latest_impot;
    public int|float $locHebdo;
    public int|float $rembHebdo;
    public int|float $totalRemb;

    public function mount()
    {
        foreach (auth()->user()->userRailwayLigne as $ligne) {
            $this->benefice_ligne = (new UserRailwayLigneAction($ligne))->getBenefice(now()->subDays(7), now());
        }
        $this->tresorerie_structurel = (new UserRailwayCompanyAction(auth()->user()->railway_company))->getTresorerieStructurel(now()->subDay(), now()->subDay());
        $this->latest_impot = auth()->user()->railway_company->last_impot;
        $this->locHebdo = (new UserRailwayCompanyAction(auth()->user()->railway_company))->getLocationMateriel(now()->subDays(7), now()->subDay());
        $this->totalRemb = auth()->user()->railway->userRailwayEmprunts()->where('status', 'pending')->sum('amount_emprunt');
        $this->rembHebdo = auth()->user()->railway->userRailwayEmprunts()->where('status', 'pending')->sum('amount_hebdo');
    }

    public function render()
    {
        return view('livewire.game.finance.resume-card');
    }
}
