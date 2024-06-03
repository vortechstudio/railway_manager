<?php

namespace App\Livewire\Game\Planning;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PlanningAutomated extends Component
{
    use LivewireAlert;

    public bool $automated_planning;

    public function mount(): void
    {
        $this->automated_planning = auth()->user()->railway->automated_planning;
    }

    public function updatedAutomatedPlanning(): void
    {
        auth()->user()->railway()->update([
            'automated_planning' => $this->automated_planning,
        ]);

        $this->alert('success', 'Configuration changer !');
        $this->redirectRoute('network.planning.editing');
    }

    public function render()
    {
        return view('livewire.game.planning.planning-automated');
    }
}
