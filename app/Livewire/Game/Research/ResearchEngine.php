<?php

namespace App\Livewire\Game\Research;

use Livewire\Attributes\On;
use Livewire\Component;

class ResearchEngine extends Component
{
    public int $research_mat = 0;

    public function mount()
    {
        $this->research_mat = auth()->user()->railway->research_mat;
    }

    #[On('refreshSoldeMat')]
    public function upSoldeMat()
    {
        $this->research_mat = auth()->user()->railway->research_mat;
    }

    public function render()
    {
        return view('livewire.game.research.research-engine');
    }
}
