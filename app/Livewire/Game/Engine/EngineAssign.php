<?php

namespace App\Livewire\Game\Engine;

use App\Actions\Railway\EngineAction;
use App\Models\User\Railway\UserRailwayEngine;
use App\Models\User\Railway\UserRailwayHub;
use App\Services\Models\Railway\Engine\RailwayEngineAction;
use App\Services\Models\User\Railway\UserRailwayEngineAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EngineAssign extends Component
{
    use LivewireAlert;
    public UserRailwayEngine $engine;

    public function assign(int $user_railway_hub_id)
    {
        UserRailwayHub::find($user_railway_hub_id)->userRailwayEngine()->delete();
        UserRailwayHub::find($user_railway_hub_id)->userRailwayEngine()->create([
            'number' => (new EngineAction())->generateMissionCode($this->engine->railwayEngine, UserRailwayHub::find($user_railway_hub_id)),
            'max_runtime' => (new RailwayEngineAction($this->engine->railwayEngine))->maxRuntime(),
            'available' => true,
            'date_achat' => now(),
            'user_id' => auth()->user()->id,
            'railway_engine_id' => $this->engine->railwayEngine->id,
            'user_railway_hub_id' => $user_railway_hub_id,
            'status' => 'free',
            'active' => true,
        ]);
        $this->alert('success', "Rame réassocié avec succès");
    }

    public function render()
    {
        return view('livewire.game.engine.engine-assign');
    }
}
