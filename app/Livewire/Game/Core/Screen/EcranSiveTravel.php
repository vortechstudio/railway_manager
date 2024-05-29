<?php

namespace App\Livewire\Game\Core\Screen;

use App\Models\Railway\Planning\RailwayPlanning;
use Carbon\Carbon;
use Livewire\Component;

class EcranSiveTravel extends Component
{
    public RailwayPlanning $planning;

    public function render()
    {
        return view('livewire.game.core.screen.ecran-sive-travel');
    }

    public function calcPercentTimeInPercent($departureActualStation, $arrivalNextStation): float|int
    {
        $start = Carbon::createFromTimestamp(strtotime($departureActualStation))->timestamp;
        $end = Carbon::createFromTimestamp(strtotime($arrivalNextStation))->timestamp;
        $timespan = $end - $start;
        $current = now()->timestamp - $start;
        $progress = $current / $timespan;
        $remaining = ($progress) * 100;
        if ($remaining >= 100) {
            return 100;
        } else {
            return $remaining;
        }
    }
}
