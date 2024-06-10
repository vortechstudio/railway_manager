<?php

namespace App\Livewire\Gare\Engine;

use App\Models\Railway\Planning\RailwayIncident;
use Livewire\Component;

class IncidentGraph extends Component
{
    public float|int $amountRepareDay = 0;

    public function mount()
    {
        $this->amountRepareDay = auth()->user()->railway_incidents()->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->sum('amount_reparation');
    }

    public function render()
    {
        return view('livewire.gare.engine.incident-graph');
    }
}
