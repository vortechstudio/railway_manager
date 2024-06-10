<?php

namespace App\Livewire\Gare\Engine;

use Livewire\Component;

class EngineGraphUsure extends Component
{
    public int|float $percent_graph_used = 0;

    public function mount()
    {
        $rameUsed = auth()->user()->railway_engines()->whereBetween('use_percent', [33,100])->count();
        $allRame = auth()->user()->railway_engines()->count();

        $this->percent_graph_used = $allRame * $rameUsed / 100;
    }
    public function render()
    {
        return view('livewire.gare.engine.engine-graph-usure');
    }
}
