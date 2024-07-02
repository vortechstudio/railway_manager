<?php

namespace App\Livewire\Game\Engine;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\CheckoutAction;
use App\Actions\Railway\EngineAction;
use App\Jobs\DeliveryJob;
use App\Models\Railway\Config\RailwaySetting;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\User\Railway\UserRailwayEngine;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\Railway\UserRailwayLigne;
use App\Services\Models\Railway\Engine\RailwayEngineAction;
use Carbon\Carbon;
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
    public ?int $user_railway_ligne_id;

    public UserRailwayLigne $userRailwayLigne;

    public $price_order;
    public array $potentialDemande = [];

    public function mount(): void
    {
        $this->engines = RailwayEngine::all();
    }

    public function query()
    {
        return RailwayEngine::with('technical', 'price')
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
            });
    }

    public function updated(): void
    {
        $this->engines = $this->query()->get();
    }

    public function updatedSelectedEngine(): void
    {
        $this->engineData = RailwayEngine::find($this->selectedEngine);
        $this->recalculate();
    }

    public function updatedUserRailwayLigneId()
    {
        $this->userRailwayLigne = UserRailwayLigne::find($this->user_railway_ligne_id);

        $FreqBase = 0;
        foreach ($this->userRailwayLigne->railwayLigne->stations as $station) {
            $FreqBase += $station->gare->freq_base;
        }
        $avgPlace = intval(($FreqBase / $this->userRailwayLigne->railwayLigne->stations()->count()) / 365 / 24);

        $prix_kilometer = RailwaySetting::where('name', 'price_kilometer')->first()->value;
        $prix_electrique = RailwaySetting::where('name', 'price_electricity')->first()->value;
        $energie =($this->userRailwayLigne->railwayLigne->distance * $prix_kilometer) + ($this->userRailwayLigne->railwayLigne->time_min / 60) * ($prix_electrique) / $this->userRailwayLigne->user->railway_company->frais;
        $this->potentialDemande = [$this->userRailwayLigne->min_passengers, $this->userRailwayLigne->max_passengers];

        $this->engines = $this->query()
            ->when($this->user_railway_ligne_id, function (Builder $query) {
                $query->join('railway_engine_technicals', 'railway_engine_technicals.railway_engine_id', '=', 'railway_engines.id')
                    ->whereBetween('railway_engine_technicals.nb_marchandise', [$this->userRailwayLigne->min_passengers, $this->userRailwayLigne->max_passengers]);
            })
            ->get();
    }

    public function validateConfig(): void
    {
        $this->validateConfig = true;
    }

    public function updatedQte()
    {
        $this->recalculate();
    }

    public function recalculate()
    {
        $subtotal = $this->engineData->price->achat * $this->qte;
        $totalAmount = 0;
        $amount_reduction = 0;
        if ($this->engineData->price->in_reduction) {
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

    public function checkout(): void
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
    public function confirmed(): void
    {
        try {
            if(!(new CheckoutAction())->checkoutArgent($this->globalAmount)) {
                $this->alert('error', 'Argent Insuffisant', [
                    'title' => 'Argent Insuffisant',
                    'text' => "Votre Solde ne permet pas l'achat de cette rame !",
                    'toast' => false,
                    'position' => 'center',
                ]);
            } else {
                (new Compta())->create(
                    user: auth()->user(),
                    title: "Achat de matériel roulant: x{$this->qte} {$this->engineData->name}",
                    amount: $this->globalAmount,
                    type_amount: 'charge',
                    type_mvm: 'achat_materiel',
                    user_railway_hub_id: $this->user_railway_hub_id,
                );
                $hub = UserRailwayHub::find($this->user_railway_hub_id);

                for ($i = 1; $i <= $this->qte; $i++) {
                    $user_engine = auth()->user()->railway_engines()->create([
                        'number' => (new EngineAction())->generateMissionCode($this->engineData, $hub),
                        'max_runtime' => (new RailwayEngineAction($this->engineData))->maxRuntime(),
                        'available' => true,
                        'date_achat' => now(),
                        'user_id' => auth()->user()->id,
                        'railway_engine_id' => $this->engineData->id,
                        'user_railway_hub_id' => $this->user_railway_hub_id,
                        'status' => 'free',
                        'siege' => $this->engineData->technical->nb_marchandise
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
                }

                $this->dispatch('refreshToolbar');
                $this->alert('success', "L'achat a bien été effectué.<br />N'oubliez pas d'assigner cette rame à une ligne.", [
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'OK',
                    'onConfirmed' => 'redirect',
                    'toast' => false,
                    'allowOutsideClick' => false,
                    'timer' => null,
                    'position' => 'center',
                ]);
            }
        } catch (\Exception $e) {
            (new ErrorDispatchHandle())->handle($e);
        }
    }

    #[On('redirect')]
    public function res(): void
    {
        $this->redirectRoute('train.index');
    }

    public function render()
    {
        return view('livewire.game.engine.engine-sell-list');
    }
}
