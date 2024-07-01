<?php

namespace App\Livewire\Game\Finance;

use Livewire\Component;

class ComptaLivreTable extends Component
{
    public string $tab = 'histo_daily';
    public function render()
    {
        return view('livewire.game.finance.compta-livre-table');
    }
}
