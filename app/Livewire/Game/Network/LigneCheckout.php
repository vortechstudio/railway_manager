<?php

namespace App\Livewire\Game\Network;

use App\Actions\Compta;
use App\Jobs\DeliveryJob;
use App\Models\Railway\Config\RailwayFluxMarket;
use App\Models\Railway\Ligne\RailwayLigne;
use App\Models\User\Railway\UserRailwayLigne;
use App\Services\Models\User\Railway\UserRailwayLigneAction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Vortechstudio\Helpers\Facades\Helpers;

class LigneCheckout extends Component
{
    use LivewireAlert;

    public $hubs;

    public Collection $lignes;

    public RailwayLigne $ligne;

    public $selectedHubValue;

    public $railway_ligne_id;

    public $price_base;

    public $subvention_percent;

    public $subvention_amount;

    public $flux_ligne_percent;

    public $flux_ligne_amount;

    public $amount_paid;

    public string $nameLigne = '';

    public ?Collection $infoLigne;

    public function mount(): void
    {
        $this->lignes = collect();
        $this->flux_ligne_percent = RailwayFluxMarket::where('date', Carbon::today())->first()->flux_ligne;
    }

    public function render()
    {
        return view('livewire.game.network.ligne-checkout');
    }

    public function updatedSelectedHubValue(): void
    {
        $this->lignes = (new RailwayLigne)
            ->where('railway_hub_id', $this->selectedHubValue)
            ->get();
    }

    public function updatedRailwayLigneId(): void
    {
        $this->ligne = RailwayLigne::find($this->railway_ligne_id);
        $this->nameLigne = $this->ligne->name;
        $this->price_base = $this->ligne->price;
        $this->subvention_percent = auth()->user()->userRailwayLigne()->count() > 1 ? auth()->user()->railway_company->subvention : 85;
        $this->subvention_amount = $this->price_base * $this->subvention_percent / 100;
        $this->flux_ligne_amount = ($this->price_base - $this->subvention_amount) * $this->flux_ligne_percent / 100;
        $this->amount_paid = $this->price_base - $this->subvention_amount - $this->flux_ligne_amount;

        $this->infoLigne = collect()->push([
            'name' => $this->nameLigne,
            'distance' => $this->ligne->distance,
            'temp_parcoure' => $this->ligne->time_min,
            'type' => $this->ligne->type->name,
            'gare_depart' => $this->ligne->start->name,
            'gare_arrivee' => $this->ligne->end->name,
            'nb_stations' => $this->ligne->stations->count(),
        ]);
    }

    #[On('confirmed')]
    public function check(): void
    {
        if (auth()->user()->userRailwayLigne()->where('railway_ligne_id', $this->railway_ligne_id)->exists()) {
            $this->alert('warning', 'Cette ligne est déjà acquise par votre compagnie');
        } elseif (auth()->user()->userRailwayLigne()->count() > auth()->user()->userRailwayHub()->find($this->selectedHubValue)->ligne_limit) {
            $this->alert('error', 'Limite atteinte', [
                'title' => 'Limite atteinte',
                'text' => 'Le nombre de ligne pour ce hub à été atteint, Veuillez augmenté le niveau de votre hub !',
                'toast' => false,
                'position' => 'center',
            ]);
        } else {
            (new Compta())->create(
                user: auth()->user(),
                title: "Achat de la ligne: {$this->ligne->name}",
                amount: $this->amount_paid,
                type_amount: 'charge',
                type_mvm: 'achat_ligne',
                user_railway_hub_id: $this->selectedHubValue,
            );

            $userLigne = auth()->user()->userRailwayLigne()->create([
                'date_achat' => Carbon::now(),
                'nb_depart_jour' => 0,
                'quai' => rand(1, 25),
                'active' => false,
                'user_railway_hub_id' => auth()->user()->userRailwayHub()->where('railway_hub_id', $this->selectedHubValue)->first()->id,
                'railway_ligne_id' => $this->railway_ligne_id,
                'user_railway_engine_id' => null,
                'user_id' => auth()->user()->id,
            ]);
            $userLigne->update(['nb_depart_jour' => rand(4, 9)]);

            $delivery = auth()->user()->userRailwayDelivery()->create([
                'type' => 'ligne',
                'designation' => "Ligne: {$this->ligne->name}",
                'start_at' => now(),
                'end_at' => now()->addMinutes(5 / auth()->user()->railway_company->livraison),
                'user_id' => auth()->user()->id,
                'model' => UserRailwayLigne::class,
                'model_id' => $userLigne->id,
            ]);

            $this->alert('success', 'La ligne à bien été acheter avec succes !');
            $this->dispatch('refreshToolbar');
            dispatch(new DeliveryJob($delivery))->delay($delivery->end_at)->onQueue('delivery');
            $this->redirectRoute('network.index');
        }
    }

    public function checkout(): void
    {
        $this->alert('question', 'Etes-vous sur de vouloir acheter cette ligne pour '.Helpers::eur($this->amount_paid).' ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Acheter la ligne',
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
}
