<?php

namespace App\Livewire\Game\Network;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Models\User\Railway\UserRailwayHub;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
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
