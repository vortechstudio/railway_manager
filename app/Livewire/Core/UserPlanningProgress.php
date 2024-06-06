<?php

namespace App\Livewire\Core;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class UserPlanningProgress extends Component
{
    public $plannings;

    public function mount(): void
    {
        $this->plannings = auth()->user()->railway_plannings()->whereBetween('date_depart', [now(), now()->endOfDay()])
            ->where(function (Builder $query) {
                $query->where('status', 'departure')
                    ->orWhere('status', 'travel')
                    ->orWhere('status', 'in_station');
            })
            ->orderBy('date_depart')
            ->get();
    }

    public function render()
    {
        return view('livewire.core.user-planning-progress');
    }
}
