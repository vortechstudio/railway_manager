<?php

namespace App\Livewire\Game\Network;

use App\Models\User\Railway\UserRailwayLigne;
use Livewire\Component;

class LigneDetail extends Component
{
    public UserRailwayLigne $ligne;

    public function render()
    {
        return view('livewire.game.network.ligne-detail');
    }
}
