<?php

namespace App\Livewire\Game\Network;

use App\Models\User\Railway\UserRailwayHub;
use Livewire\Component;

class HubDetailPanel extends Component
{
    public UserRailwayHub $hub;

    public function render()
    {
        return view('livewire.game.network.hub-detail-panel');
    }
}
