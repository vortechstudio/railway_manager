<?php

namespace App\Livewire\Game\Finance;

use App\Models\Railway\Config\RailwayBanque;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BankCard extends Component
{
    use LivewireAlert;
    public RailwayBanque $banque;

    public function render()
    {
        return view('livewire.game.finance.bank-card');
    }
}
