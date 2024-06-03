<?php

namespace App\Livewire\Game\Engine;

use App\Models\User\Railway\UserRailwayEngine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EngineDetail extends Component
{
    use LivewireAlert;
    public UserRailwayEngine $engine;
    public function render()
    {
        return view('livewire.game.engine.engine-detail');
    }
}
