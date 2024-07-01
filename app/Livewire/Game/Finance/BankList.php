<?php

namespace App\Livewire\Game\Finance;

use App\Models\Railway\Config\RailwayBanque;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class BankList extends Component
{
    use LivewireAlert;

    public function render()
    {
        return view('livewire.game.finance.bank-list', [
            'banques' => RailwayBanque::all(),
        ]);
    }
}
