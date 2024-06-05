<?php

namespace App\Livewire\Game\Planning;

use App\Models\User\Railway\UserRailwayEngine;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\Railway\UserRailwayLigne;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class PlanningListByDate extends Component
{
    public $type;

    public UserRailwayHub $hub;

    public UserRailwayLigne $ligne;

    public UserRailwayEngine $engine;

    public $plannings;

    public $selectedDate;

    public $allDates = [];

    public function mount(): void
    {
        $this->selectedDate = $this->selectedDate ? Carbon::parse($this->selectedDate)->startOfDay() : now()->startOfDay();
        $this->allDates = [
            Carbon::now()->subDays(3)->startOfDay(),
            Carbon::now()->subDays(2)->startOfDay(),
            Carbon::now()->subDays(1)->startOfDay(),
            Carbon::now()->startOfDay(),
            Carbon::now()->addDays(1)->startOfDay(),
            Carbon::now()->addDays(2)->startOfDay(),
            Carbon::now()->addDays(3)->startOfDay(),
        ];
        $query = match ($this->type) {
            default => auth()->user()->railway_plannings()->with('travel', 'passengers', 'userRailwayEngine', 'incidents'),
            'hub' => $this->hub->plannings()->with('travel', 'passengers', 'userRailwayEngine', 'incidents'),
            'ligne' => $this->ligne->plannings()->with('travel', 'passengers', 'userRailwayEngine', 'incidents'),
            'engine' => $this->engine->plannings()->with('travel', 'passengers', 'userRailwayEngine', 'incidents'),
        };
        $this->plannings = $query->when($this->selectedDate, fn (Builder $query) => $query->whereBetween('date_depart', [$this->selectedDate, Carbon::parse($this->selectedDate)->endOfDay()]))
            ->get();
        //dd($this->selectedDate);
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = Carbon::parse($date)->startOfDay();
        $query = match ($this->type) {
            default => auth()->user()->railway_plannings()->with('travel', 'passengers', 'userRailwayEngine', 'incidents'),
            'hub' => $this->hub->plannings()->with('travel', 'passengers', 'userRailwayEngine', 'incidents'),
        };
        $this->plannings = $query->when($this->selectedDate, fn (Builder $query) => $query->whereBetween('date_depart', [$this->selectedDate, Carbon::parse($this->selectedDate)->endOfDay()]))
            ->get();
    }

    public function render()
    {
        return view('livewire.game.planning.planning-list-by-date');
    }
}
