<?php

namespace App\Livewire\Game\Network;

use Livewire\Component;

class HubDetailPanel extends Component
{
    public $hub;
    public function render()
    {
        return view('livewire.game.network.hub-detail-panel');
    }
}
