<?php

namespace App\Livewire\Game\Engine;

use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\Railway\UserRailwayLigne;
use Livewire\Component;

class EngineList extends Component
{
    public $type;

    public UserRailwayHub $hub;

    public UserRailwayLigne $ligne;

    public $engines;

    public function mount(): void
    {
        $this->engines = match ($this->type) {
            default => auth()->user()->railway_engines()->with('railwayEngine')->get(),
            'hub' => $this->hub->userRailwayEngine()->with('railwayEngine')->get(),
            'ligne' => $this->ligne->userRailwayEngine()->with('railwayEngine')->get(),
        };
    }

    public function render()
    {
        return view('livewire.game.engine.engine-list');
    }
}
