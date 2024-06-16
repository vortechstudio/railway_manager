<?php

namespace App\Livewire\Game\Network;

use App\Actions\ErrorDispatchHandle;
use App\Models\User\Railway\UserRailwayHub;
use App\Services\Models\User\Railway\UserRailwayHubPublicityAction;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HubRentPublicityPanel extends Component
{
    use LivewireAlert;
    public UserRailwayHub $hub;
    public Collection $contracts;
    public int $totalSlot = 0;
    public int $occupiedSlot = 0;
    public int $revoqueContractId = 0;

    public function mount()
    {
        $this->generateContracts();
        $this->totalSlot = $this->hub->publicity_limit;
        $this->occupiedSlot = $this->hub->publicity_actual;
    }

    public function select(string $societe, int $nb_slot, int $contract_duration, float $ca_prev, int|float $amount_invest)
    {
        try {
            if ($nb_slot > $this->totalSlot - $this->occupiedSlot) {
                $this->alert('warning', "Pas assez d'emplacement disponible !");
            } else {
                $this->hub->publicities()->create([
                    'societe' => $societe,
                    'nb_slot' => $nb_slot,
                    'amount_invest' => $amount_invest,
                    'nb_day_contract' => $contract_duration,
                    'ca_daily' => $ca_prev,
                    'start_at' => now(),
                    'end_at' => now()->addDays($contract_duration),
                    'user_railway_hub_id' => $this->hub->id
                ]);

                $this->hub->publicity_actual += $nb_slot;
                $this->hub->save();

                $this->alert('success', "Contrat publicitaire établie");
                $this->generateContracts();
            }
            $this->dispatch('closeModal', 'modalpublicities');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }
    }

    public function generateContracts()
    {
        $this->contracts = collect();
        for ($i=1; $i < 15; $i++) {
            if(fake()->boolean(70)) {
                $base_ca = rand(5000,150000);
            } elseif (fake()->boolean(20)) {
                $base_ca = rand(150001, 500000);
            } else {
                $base_ca = rand(500001, 1000000);
            }

            $nb_slot = (new UserRailwayHubPublicityAction())->getSlotOfInvest($base_ca);
            $name_company = fake()->company;
            $base_amount_ca_daily = $base_ca * (new UserRailwayHubPublicityAction())->getBaremeOfInvest($base_ca) / 100;
            $nb_contract_day = rand(15,365);
            $amount_ca_daily = ($base_amount_ca_daily / $nb_contract_day) * $nb_slot;
            $this->contracts->add([
                'societe' => $name_company,
                'nb_slot' => $nb_slot,
                'amount_invest' => $base_ca,
                'ca_prev_percent' => (new UserRailwayHubPublicityAction())->getBaremeOfInvest($base_ca),
                'ca_prev' => $amount_ca_daily,
                'contract_duration_day' => $nb_contract_day
            ]);
        }
    }

    public function render()
    {
        return view('livewire.game.network.hub-rent-publicity-panel');
    }
}
