<?php

namespace App\Livewire\Game\Core\Screen;

use App\Models\Railway\Planning\RailwayPlanning;
use Livewire\Component;

class EcranDepartureSingle extends Component
{
    public RailwayPlanning $planning;

    public function render()
    {
        return view('livewire.game.core.screen.ecran-departure-single');
    }
}
