<?php

namespace App\Livewire\Game\Planning;

use App\Models\Railway\Planning\RailwayPlanningConstructor;
use App\Models\User\Railway\UserRailwayEngine;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PlanningManual extends Component
{
    use LivewireAlert;

    public $user_railway_engine_id;

    public $date_depart;

    public ?array $day;

    public $number_repeat;

    public $repeat;

    public function save(): void
    {
        $engine = UserRailwayEngine::find($this->user_railway_engine_id);
        $hour_ex = explode(':', $this->date_depart);
        $heure_depart = Carbon::createFromTime($hour_ex[0], $hour_ex[1], 0);
        $heure_arrive = Carbon::createFromTime($hour_ex[0], $hour_ex[1], 0)->addMinutes($engine->userRailwayLigne->railwayLigne->time_min);

        if ($engine->constructors()->count() > $engine->userRailwayLigne->nb_depart_jour) {
            $this->alert('error', 'Limite Atteinte', [
                'title' => 'Limite Atteinte',
                'text' => 'Vous avez atteint le nombre de départ par jour pour cette ligne, la planification est indisponible !',
                'toast' => false,
                'position' => 'center',
            ]);
        }

        if ($engine->constructors()->exists()) {
            $first = $engine->constructors()->first();
            $last = $engine->constructors()->orderBy('id', 'desc')->first();

            if ($heure_depart >= $first->start_at && $heure_depart <= $last->end_at || in_array($this->day, json_decode($first->day_of_week))) {
                $this->alert('error', 'Le planning est déjà disponible');
            }
        }

        RailwayPlanningConstructor::create([
            'start_at' => $heure_depart,
            'end_at' => $heure_arrive,
            'day_of_week' => json_encode($this->day),
            'user_id' => auth()->user()->id,
            'user_railway_engine_id' => $engine->id,
            'repeat' => (bool) $this->repeat,
            'repeat_end_at' => $this->calcEndAtFromWeek(),
        ]);

        $this->alert('success', 'Planning enregistré');
        $this->dispatch('closeModal', 'newPlanning');
    }

    private function calcEndAtFromWeek()
    {
        return match ($this->repeat) {
            'hebdo' => now()->startOfWeek()->addWeeks($this->number_repeat)->endOfWeek(),
            'mensuel' => now()->startOfWeek()->addMonths($this->number_repeat)->endOfWeek(),
            'trim' => now()->startOfWeek()->addMonths($this->number_repeat * 3)->endOfWeek(),
            'sem' => now()->startOfWeek()->addMonths($this->number_repeat * 6)->endOfWeek(),
            'annual' => now()->startOfWeek()->addYears($this->number_repeat)->endOfWeek(),
            default => null
        };
    }

    public function render()
    {
        return view('livewire.game.planning.planning-manual', [
            'engines' => auth()->user()->railway_engines()->with('railwayEngine', 'constructors')->get(),
        ]);
    }
}
