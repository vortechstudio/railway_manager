<?php

namespace App\Livewire\Game\Engine;

use App\Actions\CheckoutAction;
use App\Actions\Compta;
use App\Livewire\Core\Toolbar;
use App\Models\User\Railway\UserRailwayEngineTechnicentre;
use App\Services\Models\User\Railway\UserRailwayEngineTechnicentreAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class EngineMaintenance extends Component
{
    use LivewireAlert;

    public $engineTechnicentres;

    public UserRailwayEngineTechnicentre $maintenance;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->engineTechnicentres = auth()->user()->userRailwayEngineTechnicentre;
    }

    public function accelerate(int $maintenance_id)
    {
        $this->maintenance = UserRailwayEngineTechnicentre::find($maintenance_id);
        $this->alert('question', 'Etes-vous sur de vouloir accélérer cette maintenance pour '.$this->maintenance->end_at->diffInMinutes(now()).' Tpoint ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Oui',
            'onConfirmed' => 'confirmed',
            'toast' => false,
            'allowOutsideClick' => false,
            'timer' => null,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Non',
            'cancelButtonColor' => '#ef5350',
        ]);
    }

    #[On('confirmed')]
    public function confirmed()
    {
        if ((new CheckoutAction())->checkoutTpoint($this->maintenance->end_at->diffInMinutes(now()))) {
            (new UserRailwayEngineTechnicentreAction($this->maintenance))->delivered();
            (new Compta())->create(
                user: $this->maintenance->user,
                title: 'Maintenance effectuer sur matériel',
                amount: $this->maintenance->amount_du,
                type_amount: 'charge',
                type_mvm: 'maintenance_engine',
                valorisation: false,
                user_railway_ligne_id: $this->maintenance->userRailwayEngine->userRailwayLigne->id,
                user_railway_hub_id: $this->maintenance->userRailwayEngine->userRailwayHub->id,
            );
            $this->dispatch('refreshComponent')->self();
            $this->dispatch('refreshToolbar')->to(Toolbar::class);
        } else {
            $this->alert('warning', "Vous n'avez pas assez de Travel Point");
        }
    }

    public function render()
    {
        return view('livewire.game.engine.engine-maintenance');
    }
}
