<?php

namespace App\Livewire\Game\Core;

use App\Models\User\Railway\UserRailwayLigne;
use Carbon\Carbon;
use Livewire\Component;

class ScreenDeparture extends Component
{
    public $type;

    public UserRailwayLigne $ligne;

    public $plannings;

    public function mount(): void
    {
        $this->plannings = match ($this->type) {
            default => auth()->user()->railway_plannings()
                ->with('userRailwayHub', 'userRailwayLigne', 'userRailwayEngine')
                ->whereBetween('date_depart', [now(), now()->endOfDay()])
                ->where('status', 'initialized')
                ->orWhere('status', 'departure')
                ->orWhere('status', 'retarded')
                ->orWhere('status', 'cancelled')
                ->orderBy('date_depart')
                ->limit(5)
                ->get(),
            'ligne' => $this->ligne->plannings()
                ->with('userRailwayHub', 'userRailwayLigne', 'userRailwayEngine')
                ->whereBetween('date_depart', [now(), now()->endOfDay()])
                ->where('status', 'initialized')
                ->orWhere('status', 'departure')
                ->orWhere('status', 'retarded')
                ->orWhere('status', 'cancelled')
                ->orderBy('date_depart')
                ->limit(5)
                ->get()
        };
    }

    public function render()
    {
        return view('livewire.game.core.screen-departure');
    }
}
