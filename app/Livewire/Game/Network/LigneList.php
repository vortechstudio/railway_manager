<?php

namespace App\Livewire\Game\Network;

use Livewire\Component;

class LigneList extends Component
{
    public function render()
    {
        return view('livewire.game.network.ligne-list', [
            'lignes' => auth()->user()->userRailwayLigne()->with('tarifs', 'railwayLigne')->where('active', true)->get(),
        ]);
    }
}
