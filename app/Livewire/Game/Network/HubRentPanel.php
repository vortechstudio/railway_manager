<?php

namespace App\Livewire\Game\Network;

use App\Models\User\Railway\UserRailwayHub;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HubRentPanel extends Component
{
    use LivewireAlert;

    public UserRailwayHub $hub;

    public function render()
    {
        return view('livewire.game.network.hub-rent-panel');
    }
}
