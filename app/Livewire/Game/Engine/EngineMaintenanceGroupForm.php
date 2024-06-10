<?php

namespace App\Livewire\Game\Engine;

use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class EngineMaintenanceGroupForm extends Component
{
    use LivewireAlert;
    public string $type = '';
    public int $selectedUsure = 0;
    public int $selectedAncien = 0;
    public array $selectedEngines = [];
    public int|float $amount_prev = 0;
    public int|float $amount_cur = 0;
    public $engines;

    public function mount()
    {
        $this->engines = auth()->user()->railway_engines;
    }

    #[On('sliderUsureUpdated')]
    public function usureUpdated($values)
    {
        $this->selectedUsure = intval($values);
    }

    #[On('sliderAncienUpdated')]
    public function ancienUpdate($values)
    {
        $this->selectedAncien = intval($values);
    }

    public function updateEngineList()
    {
        $this->engines = auth()->user()->railway_engines()
            ->when($this->selectedUsure, fn(Builder $query) => $query->where('use_percent', $this->selectedUsure))
            ->when($this->selectedAncien, fn(Builder $query) => $query->where('older', $this->selectedAncien))
            ->get();
    }
    public function render()
    {
        return view('livewire.game.engine.engine-maintenance-group-form');
    }
}
