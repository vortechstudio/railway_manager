<?php

namespace App\Livewire\Gare\Engine;

use Livewire\Component;

class EngineGraphAncien extends Component
{
    public int|float $percent_graph_ancien = 0;

    public function mount()
    {
        $rameUsed = auth()->user()->railway_engines()->whereBetween('older', [3, 5])->count();
        $allRame = auth()->user()->railway_engines()->count();

        $this->percent_graph_ancien = $allRame * $rameUsed / 100;
    }

    public function render()
    {
        return view('livewire.gare.engine.engine-graph-ancien');
    }
}
