<?php

namespace App\Livewire\Game\Research;

use App\Models\Railway\Research\RailwayResearches;
use Livewire\Component;

class ResearchTreeNode extends Component
{
    public RailwayResearches $research;
    public function render()
    {
        return view('livewire.game.research.research-tree-node');
    }
}
