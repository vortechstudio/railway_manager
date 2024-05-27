<?php

namespace App\Livewire\Game\Engine;

use App\Models\Railway\Planning\RailwayPlanning;
use Livewire\Component;

class IncidentList extends Component
{
    public $type = '';

    public $showing = 'simple';

    public RailwayPlanning $planning;

    public $incidents;

    public function mount(): void
    {
        $this->incidents = match ($this->type) {
            default => auth()->user()->railway_incidents()->with('userRailwayHub', 'userRailwayEngine', 'railwayPlanning')->get(),
            'planning' => $this->planning->incidents()->with('userRailwayHub', 'userRailwayEngine')->get(),
        };
    }

    public function render()
    {
        return view('livewire.game.engine.incident-list');
    }
}
