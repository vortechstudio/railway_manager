<?php

namespace App\Livewire\Game\Network;

use App\Actions\Compta;
use App\Jobs\DeliveryJob;
use App\Models\Railway\Config\RailwayFluxMarket;
use App\Models\Railway\Gare\RailwayHub;
use App\Models\User\Railway\UserRailwayHub;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Vortechstudio\Helpers\Facades\Helpers;

class HubCheckout extends Component
{
    use LivewireAlert;

    public $selectedHub = 0;

    public $hubs;

    public $price_base;

    public $subvention_percent;

    public $subvention_amount;

    public $flux_hub_percent;

    public $flux_hub_amount;

    public $amount_paid;

    public function mount(): void
    {
        $this->flux_hub_percent = RailwayFluxMarket::where('date', Carbon::today())->first()->flux_hub;
    }

    public function updatedSelectedHub($value): void
    {
        $hub = RailwayHub::find($value);
        $this->price_base = $hub->price_base;
        $this->subvention_percent = auth()->user()->userRailwayHub()->count() > 1 ? auth()->user()->railway_company->subvention : 85;
        $this->subvention_amount = $this->price_base * $this->subvention_percent / 100;
        $this->flux_hub_amount = ($this->price_base - $this->subvention_amount) * $this->flux_hub_percent / 100;
        $this->amount_paid = $this->price_base - $this->subvention_amount + $this->flux_hub_amount;
    }

    public function checkout(): void
    {
        $this->alert('question', 'Etes-vous sur de vouloir acheter ce hub pour '.Helpers::eur($this->amount_paid).' ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Acheter le hub',
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
    public function check(): void
    {
        $hub = RailwayHub::find($this->selectedHub);
        if (auth()->user()->userRailwayHub()->where('railway_hub_id', $this->selectedHub)->exists()) {
            $this->alert('warning', 'Vous ne pouvez pas acheter un hub déjà acquis !');
        } else {
            (new Compta())->create(
                user: auth()->user(),
                title: 'Achat du hub',
                amount: $this->amount_paid,
                type_amount: 'charge',
                type_mvm: 'achat_hub',
            );

            $userHub = auth()->user()->userRailwayHub()->create([
                'date_achat' => Carbon::today(),
                'km_ligne' => 0,
                'commerce' => true,
                'publicity' => true,
                'parking' => true,
                'commerce_limit' => $hub->gare->nb_max_commerce,
                'publicity_limit' => $hub->gare->nb_max_publicite,
                'parking_limit' => $hub->gare->nb_max_parking,
                'ligne_limit' => 4,
                'user_id' => auth()->user()->id,
                'railway_hub_id' => $hub->id,
                'active' => false,
            ]);

            $delivery = auth()->user()->userRailwayDelivery()->create([
                'type' => 'hub',
                'designation' => 'Hub: '.$hub->gare->name,
                'start_at' => now(),
                'end_at' => now()->addMinutes(5 / auth()->user()->railway_company->livraison),
                'user_id' => auth()->user()->id,
                'model' => UserRailwayHub::class,
                'model_id' => $userHub->id,
            ]);

            $this->alert('success', 'Le hub à bien été acheter avec succes !');
            $this->dispatch('refreshToolbar');
            dispatch(new DeliveryJob($delivery))->delay($delivery->end_at)->onQueue('delivery');
            $this->redirectRoute('network.index');
        }
    }

    public function render()
    {
        return view('livewire.game.network.hub-checkout');
    }
}
