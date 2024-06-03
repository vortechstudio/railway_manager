<?php

namespace App\Livewire\Core;

use App\Models\Railway\Planning\RailwayPlanning;
use Livewire\Component;

class UserPlanningProgress extends Component
{
    public $plannings;

    public function mount()
    {
        $this->plannings = RailwayPlanning::whereBetween('date_depart', [now(), now()->endOfDay()])
            ->where('status', 'departure')
            ->orWhere('status', 'travel')
            ->orWhere('status', 'in_station')
            ->orderBy('date_depart')
            ->get();
    }

    public function render()
    {
        return view('livewire.core.user-planning-progress');
    }
}
