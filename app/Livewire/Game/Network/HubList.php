<?php

namespace App\Livewire\Game\Network;

use Livewire\Component;

class HubList extends Component
{
    public function render()
    {
        return view('livewire.game.network.hub-list', [
            'hubs' => auth()->user()->userRailwayHub()->where('active', true)->get(),
        ]);
    }
}
