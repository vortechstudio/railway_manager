<?php

namespace App\Livewire\Game\Finance;

use App\Models\Railway\Config\RailwayBanque;
use App\Models\User\Railway\UserRailwayEmprunt;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BankCard extends Component
{
    use LivewireAlert;
    public RailwayBanque $banque;
    public int|float $empruntExpress = 0;
    public int|float $empruntMarket = 0;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->empruntExpress = auth()->user()->railway->userRailwayEmprunts()
            ->where('type_emprunt', 'express')
            ->where('railway_banque_id', $this->banque->id)
            ->where('status', '!=', 'terminated')
            ->sum('amount_emprunt');

        $this->empruntMarket = auth()->user()->railway->userRailwayEmprunts()
            ->where('type_emprunt', 'marche')
            ->where('railway_banque_id', $this->banque->id)
            ->where('status', '!=', 'terminated')
            ->sum('amount_emprunt');
    }

    public function render()
    {
        return view('livewire.game.finance.bank-card');
    }
}
