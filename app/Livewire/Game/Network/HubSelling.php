<?php

namespace App\Livewire\Game\Network;

use App\Actions\Compta;
use App\Models\User\Railway\UserRailwayHub;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Vortechstudio\Helpers\Facades\Helpers;

class HubSelling extends Component
{
    use LivewireAlert;

    public UserRailwayHub $hub;

    public bool $sellingEngine = false;

    public float $totalSelling = 0.00;

    public float $totalLigne = 0.00;

    public float $totalEngine = 0.00;

    public float $totalFlux = 0.00;

    public function mount(): void
    {
        $this->getTotalLigne();
        $this->totalFlux = ($this->hub->simulateSelling() + $this->totalLigne) * $this->hub->flux_market / 100;
        $this->totalSelling = ($this->hub->simulateSelling() + $this->totalLigne) + $this->totalFlux;
    }

    public function getTotalLigne(): void
    {
        $this->totalLigne = 0;
        foreach ($this->hub->userRailwayLigne as $item) {
            $this->totalLigne += $item->simulateSelling();
        }
    }

    public function getTotalEngine(): void
    {
        $this->totalEngine = 0;
        foreach ($this->hub->userRailwayEngine as $item) {
            $this->totalEngine += $item->simulateSelling();
        }
    }

    public function updated(): void
    {
        if ($this->sellingEngine) {
            $this->getTotalEngine();
            $this->totalFlux = ($this->hub->simulateSelling() + $this->totalLigne + $this->totalEngine) * $this->hub->flux_market / 100;
            $this->totalSelling = ($this->hub->simulateSelling() + $this->totalLigne + $this->totalEngine) + $this->totalFlux;
        } else {
            $this->getTotalEngine();
            $this->totalFlux = ($this->hub->simulateSelling() + $this->totalLigne - $this->totalEngine) * $this->hub->flux_market / 100;
            $this->totalSelling = ($this->hub->simulateSelling() + $this->totalLigne - $this->totalEngine) + $this->totalFlux;
        }
    }

    public function sell(): void
    {
        $this->alert('question', 'Etes-vous sur de vouloir vendre ce hub pour '.Helpers::eur($this->totalSelling).' ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Vendre le hub',
            'onConfirmed' => 'confirmed',
            'toast' => false,
            'allowOutsideClick' => false,
            'timer' => null,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Annuler',
            'cancelButtonColor' => '#ef5350'
        ]);
    }

    #[On('confirmed')]
    public function selling(): void
    {
        if ($this->hub->user->userRailwayHub->count() <= 1) {
            $this->alert('error', "Vous ne pouvez pas vendre le seul hub qu'il vous reste");
        } else {
            if ($this->sellingEngine) {
                foreach ($this->hub->userRailwayEngine as $engine) {
                    if ($engine->status->value != 'free') {
                        $this->alert('error', 'Vous ne pouvez pas vendre une rame en service.');
                    } else {
                        (new Compta())->create(
                            user: auth()->user(),
                            title: "Vente de la rame: {$engine->number} / {$engine->railwayEngine->name}",
                            amount: $this->totalSelling,
                            type_amount: 'revenue',
                            type_mvm: 'vente_engine',
                        );

                        $engine->delete();
                    }
                }
            }

            foreach ($this->hub->userRailwayLigne as $ligne) {
                (new Compta())->create(
                    user: auth()->user(),
                    title: "Vente de la ligne: {$ligne->railwayLigne->start->name} / {$ligne->railwayLigne->end->name}",
                    amount: $this->totalLigne,
                    type_amount: 'revenue',
                    type_mvm: 'vente_ligne',
                );

                $ligne->delete();
            }

            (new Compta())->create(
                user: auth()->user(),
                title: "Vente du hub: {$this->hub->railwayHub->gare->name}",
                amount: $this->totalLigne,
                type_amount: 'revenue',
                type_mvm: 'vente_hub',
            );

            $this->hub->delete();
            $this->alert('success', 'Votre hub à bien été vendue');
            $this->redirectRoute('network.index');
        }
    }

    public function render()
    {
        return view('livewire.game.network.hub-selling');
    }
}
