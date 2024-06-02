<?php

namespace App\Livewire\Game\Engine;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\EngineAction;
use App\Jobs\DeliveryJob;
use App\Models\Railway\Config\RailwayRental;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\Railway\Gare\RailwayHub;
use App\Models\User\Railway\UserRailwayEngine;
use App\Models\User\Railway\UserRailwayHub;
use App\Services\Models\Railway\Engine\RailwayEngineAction;
use App\Services\Models\Railway\Engine\RailwayEnginePriceAction;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Vortechstudio\Helpers\Facades\Helpers;

class EngineRentalList extends Component
{
    use LivewireAlert;

    public $selectRental;
    public $selectEngine;
    public $selectDeliveryHub;
    public $engines;
    public $rentals;
    public RailwayEngine $engineData;
    public RailwayRental $rental;

    //filter Engine
    public $type_energy;
    public $type_transport;
    public $type_train;
    public $price_order;

    // Cart
    public $caution;
    public $qteSemaine;
    public $amountOfSemaine;
    public $frais;
    public $amountGlobal;

    public function mount()
    {
        $this->rentals = RailwayRental::all();
    }

    public function updated()
    {
        $this->engines = RailwayRental::find($this->selectRental)->engines()->with('technical', 'price')
            ->when($this->type_transport, function (Builder $query) {
                $query->where('type_transport', $this->type_transport);
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

    public function updatedSelectRental()
    {
        $this->engines = RailwayRental::find($this->selectRental)->engines()->get();
        $this->rental = RailwayRental::find($this->selectRental);
    }

    public function updatedSelectEngine()
    {
        $this->engineData = RailwayEngine::find($this->selectEngine);
        $this->caution = intval($this->engineData->price->achat - ($this->engineData->price->achat * 60 / 100));
    }

    public function updatedQteSemaine()
    {
        $this->frais = (new RailwayEnginePriceAction($this->engineData->price))->calcFrais($this->qteSemaine);
        $this->amountGlobal = $this->engineData->price->location + $this->caution;
    }

    public function checkout()
    {
        $this->alert('question', 'Etes-vous sur de vouloir louer ce matériel roulant pour ' . Helpers::eur($this->amountGlobal) . ' ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Louer le matériel',
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
                title: "Location de la rame: {$this->engineData->name}",
                amount: $this->amountGlobal,
                type_amount: 'charge',
                type_mvm: 'location_materiel',
                user_railway_hub_id: $this->selectDeliveryHub
            );
            $hub = UserRailwayHub::find($this->selectDeliveryHub);

            $user_engine = auth()->user()->railway_engines()->create([
                'number' => (new EngineAction())->generateMissionCode($this->engineData, $hub),
                'max_runtime' => (new RailwayEngineAction($this->engineData))->maxRuntime(),
                'available' => true,
                'date_achat' => now(),
                'user_id' => auth()->user()->id,
                'railway_engine_id' => $this->engineData->id,
                'user_railway_hub_id' => $this->selectDeliveryHub,
                'status' => 'free'
            ]);
            $r = rand(15, 30);
            $end_at = now()->addMinutes($r - ($r * auth()->user()->railway_company->livraison / 100));

            $delivery = auth()->user()->userRailwayDelivery()->create([
                'type' => 'engine',
                'designation' => "Rame: {$this->engineData->name}",
                'start_at' => now(),
                'end_at' => $end_at,
                'user_id' => auth()->id(),
                'model' => UserRailwayEngine::class,
                'model_id' => $user_engine->id,
            ]);
            dispatch(new DeliveryJob($delivery));
            $this->dispatch('refreshToolbar');

            $this->alert('success', "L'achat a bien été effectué.<br />N'oubliez pas d'assigner cette rame à une ligne.<br>Veuillez trouver ci-joint le tableau de vos prochains paiement:", [
                'html' => $this->getTablePrlv(),
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'onConfirmed' => 'redirect',
                'toast' => false,
                'allowOutsideClick' => false,
                'timer' => null,
                'position' => 'center',
            ]);
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    #[On('redirect')]
    public function res()
    {
        $this->redirectRoute('train.buy');
    }

    public function getTablePrlv()
    {
        ob_start();
        ?>
        <table class="table table-row-bordered rounded-3 bg-yellow-300">
            <tbody>
                <?php for ($i=0; $i <= $this->qteSemaine; $i++): ?>
                <tr>
                    <td><?= now()->addWeeks($i)->format('d/m/Y') ?></td>
                    <td><?= Helpers::eur($this->engineData->price->location) ?></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }

    public function render()
    {
        return view('livewire.game.engine.engine-rental-list');
    }
}
