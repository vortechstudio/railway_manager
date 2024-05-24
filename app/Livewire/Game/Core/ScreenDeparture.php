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

    public function mount()
    {
        $this->plannings = match ($this->type) {
            default => auth()->user()->railway_plannings()
                ->with('userRailwayHub', 'userRailwayLigne', 'userRailwayEngine')
                ->whereDate('date_depart', Carbon::today())
                ->whereNot('status', 'travel')
                ->orWhereNot('status', 'in_station')
                ->orWhereNot('status', 'arrival')
                ->get(),
            'ligne' => $this->ligne->plannings()
                ->with('userRailwayHub', 'userRailwayLigne', 'userRailwayEngine')
                ->whereDate('date_depart', Carbon::today())
                ->whereNot('status', 'travel')
                ->orWhereNot('status', 'in_station')
                ->orWhereNot('status', 'arrival')
                ->get()
        };
    }

    public function render()
    {
        return view('livewire.game.core.screen-departure');
    }
}
