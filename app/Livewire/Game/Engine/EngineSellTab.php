<?php

namespace App\Livewire\Game\Engine;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Models\User\Railway\UserRailwayEngine;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Vortechstudio\Helpers\Facades\Helpers;

class EngineSellTab extends Component
{
    use LivewireAlert;

    public UserRailwayEngine $engine;

    public $totalSelling = 0.00;

    public $totalFlux = 0.00;

    public function mount(): void
    {
        $this->totalFlux = $this->engine->simulateSelling() * $this->engine->flux_market / 100;
        $this->totalSelling = $this->engine->simulateSelling() + $this->totalFlux;
    }

    public function checkout(): void
    {
        $this->alert('question', 'Etes-vous sur de vouloir vendre cette rame pour '.Helpers::eur($this->totalSelling).' ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Vendre la rame',
            'onConfirmed' => 'confirmed',
            'toast' => false,
            'allowOutsideClick' => false,
            'timer' => null,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Annuler',
            'cancelButtonColor' => '#ef5350',
        ]);
    }

    #[On('confirmed')]
    public function confirmed(): void
    {
        try {
            $count_planning = $this->engine->plannings()->where(function (Builder $query) {
                $query->where('status', 'departure')
                    ->orWhere('status', 'arrival')
                    ->orWhere('status', 'travel')
                    ->orWhere('status', 'in_station');
            })->count();

            if ($count_planning > 0) {
                $this->alert('warning', 'Impossible de vendre une rame en cours d\'utilisation !');
            }

            (new Compta())->create(
                user: auth()->user(),
                title: "Vente de la rame {$this->engine->number} / {$this->engine->railwayEngine->name}",
                amount: $this->totalSelling,
                type_amount: 'revenue',
                type_mvm: 'vente_engine',
                user_railway_hub_id: $this->engine->userRailwayHub->id,
            );

            foreach ($this->engine->plannings as $planning) {
                $planning->delete();
            }

            $this->engine->delete();

            $this->dispatch('refreshToolbar');
            $this->alert('success', 'Votre rame à bien été vendue');
            $this->redirectRoute('train.index');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue lors de la vendre de la rame');
        }
    }

    public function render()
    {
        return view('livewire.game.engine.engine-sell-tab');
    }
}
