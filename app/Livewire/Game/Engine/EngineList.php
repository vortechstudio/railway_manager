<?php

namespace App\Livewire\Game\Engine;

use App\Actions\ErrorDispatchHandle;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\Railway\UserRailwayLigne;
use App\Services\Models\User\Railway\UserRailwayLigneAction;
use App\Services\Models\User\Railway\UserRailwayLigneTarifAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EngineList extends Component
{
    use LivewireAlert;

    public $type;

    public UserRailwayHub $hub;

    public UserRailwayLigne $ligne;

    public $engines;

    //Form Assign Ligne
    public $user_railway_engine_id;

    public $user_railway_ligne_id;

    public function mount(): void
    {
        $this->engines = match ($this->type) {
            default => auth()->user()->railway_engines()->with('railwayEngine')->get(),
            'hub' => $this->hub->userRailwayEngine()->with('railwayEngine')->get(),
            'ligne' => $this->ligne->userRailwayEngine()->with('railwayEngine')->get(),
        };
    }

    public function selectedEngine(int $engine_id): void
    {
        $this->user_railway_engine_id = $engine_id;
    }

    public function updatedUserRailwayLigneId(): void
    {
        try {
            $ligne = auth()->user()->userRailwayLigne()->find($this->user_railway_ligne_id);
            $ligne->update([
                'user_railway_engine_id' => $this->user_railway_engine_id,
            ]);
            (new UserRailwayLigneAction($ligne))->createTarif();
            $this->alert('success', 'Rame assigné !');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function render()
    {
        return view('livewire.game.engine.engine-list');
    }
}
