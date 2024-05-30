<?php

namespace App\Livewire\Game\Engine;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\EngineAction;
use App\Jobs\DeliveryJob;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\User\Railway\UserRailwayEngine;
use App\Models\User\Railway\UserRailwayHub;
use App\Services\Models\Railway\Engine\RailwayEngineAction;
use App\Services\Models\User\Railway\UserRailwayEngineAction;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Vortechstudio\Helpers\Facades\Helpers;

class EngineSellList extends Component
{
    use LivewireAlert;
    public $selectedType;
    public $selectedEngine;
    public $engines;
    public RailwayEngine $engineData;
    public bool $validateConfig = false;
    public int $qte = 1;
    public $user_railway_hub_id;
    public $globalAmount = 0;

    //filter
    public $type_energy;
    public $type_train;
    public $price_order;

    public function mount()
    {
        $this->engines = RailwayEngine::all();
    }

    public function updated()
    {
        $this->engines = RailwayEngine::with('technical', 'price')
            ->when($this->selectedType, function (Builder $query) {
                $query->where('type_transport', $this->selectedType);
            })
            ->when($this->type_energy, function (Builder $query) {
                $query->where('type_energy', $this->type_energy);
            })
            ->when($this->type_train, function (Builder $query) {
                $query->where('type_train', $this->type_train);
            })
            ->when($this->price_order, function (Builder $query) {
                $query->join('railway_engine_prices', 'railway_engine_prices.railway_engine_id', '=', 'railway_engines.id')
                    ->orderBy('railway_engine_prices.achat', $this->price_order);
            })
            ->get();
    }

    public function updatedSelectedEngine()
    {
        $this->engineData = RailwayEngine::find($this->selectedEngine);
        $subtotal = $this->engineData->price->achat * $this->qte;
        $totalAmount = 0;
        $amount_reduction = 0;
        if($this->engineData->price->in_reduction) {
            $amount_reduction += $subtotal * $this->engineData->price->percent_reduction / 100;
            $totalAmount += $subtotal - $amount_reduction;
        } else {
            $totalAmount += $subtotal;
        }

        $flux_percent = \App\Models\Railway\Config\RailwayFluxMarket::where('date', \Carbon\Carbon::today())->first()->flux_engine;
        $amount_flux = $totalAmount * $flux_percent / 100;
        $amount_subvention = $totalAmount * auth()->user()->railway_company->subvention / 100;
        $this->globalAmount = $totalAmount - $amount_flux - $amount_subvention;
    }

    public function validateConfig()
    {
        $this->validateConfig = true;
    }

    public function checkout()
    {
        $this->alert('question', 'Etes-vous sur de vouloir acheter ce matériel roulant pour '.Helpers::eur($this->globalAmount).' ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Acheter le matériel',
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
    public function confirmed()
    {
        try {
            (new Compta())->create(
                user: auth()->user(),
                title: "Achat de matériel roulant: x{$this->qte} {$this->engineData->name}",
                amount: $this->globalAmount,
                type_amount: 'charge',
                type_mvm: 'achat_materiel'
            );
            $hub = UserRailwayHub::find($this->user_railway_hub_id);

            $user_engine = auth()->user()->railway_engines()->create([
                'number' => (new EngineAction())->generateMissionCode($this->engineData, $hub),
                'max_runtime' => (new RailwayEngineAction($this->engineData))->maxRuntime(),
                'available' => false,
                'date_achat' => now(),
                'user_id' => auth()->user()->id,
                'railway_engine_id' => $this->engineData->id,
                'user_railway_hub_id' => $this->user_railway_hub_id
            ]);

            $r = rand(15,30);
            $end_at = now()->addMinutes($r - ($r * auth()->user()->railway_company->livraison / 100));

            $delivery = auth()->user()->userRailwayDelivery()->create([
                'type' => 'engine',
                'designation' => "Rame: {$this->engineData->name}",
                'start_at' => now(),
                'end_at' => $end_at,
                'user_id' => auth()->id(),
                'model' => UserRailwayEngine::class,
                'model_id' => $user_engine->id
            ]);

            dispatch(new DeliveryJob($delivery));
            $this->alert('success', "L'achat a bien été effectué.<br />N'oubliez pas d'assigner cette rame à une ligne.", [
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'onConfirmed' => 'redirect',
                'toast' => false,
                'allowOutsideClick' => false,
                'timer' => null,
                'position' => 'center',
            ]);
        } catch(\Exception $e) {
            (new ErrorDispatchHandle())->handle($e);
        }
    }

    #[On('redirect')]
    public function res()
    {
        $this->redirectRoute('train.buy');
    }

    public function render()
    {
        return view('livewire.game.engine.engine-sell-list');
    }
}
