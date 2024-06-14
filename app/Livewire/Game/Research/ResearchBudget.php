<?php

namespace App\Livewire\Game\Research;

use Livewire\Attributes\On;
use Livewire\Component;

class ResearchBudget extends Component
{
    public int|float $amount_research = 0;

    public int|float $amount_research_budget = 0;

    public function mount()
    {
        $this->amount_research = auth()->user()->railway->research;
        $this->amount_research_budget = auth()->user()->railway_company->research_coast_base;
    }

    #[On('budgetSliderUpdated')]
    public function budgetSliderUpdated($value)
    {
        $this->amount_research_budget = $value;
        auth()->user()->railway_company()->update([
            'research_coast_base' => $value,
        ]);
    }

    public function render()
    {
        return view('livewire.game.research.research-budget');
    }
}
