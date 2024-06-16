<?php

namespace App\Livewire\Game\Network;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Models\User\Railway\UserRailwayHub;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class HubRentCommercePanel extends Component
{
    use LivewireAlert;
    public UserRailwayHub $hub;
    public Collection $contracts;
    public int $totalSlot = 0;
    public int $occupiedSlot = 0;
    public int $revoqueContractId = 0;

    public function mount()
    {
        $this->contracts = collect();
        for ($i = 1; $i <= 15; $i++) {
            $nb_slot = rand(1, 5);
            $name_company = fake('fr_FR')->company;
            $base_ca = rand(500, 3500);
            $this->contracts->add([
                'societe' => $name_company,
                'nb_slot_required' => $nb_slot,
                'ca_prev' => $base_ca + ($base_ca * $this->hub->user->railway_company->rent_aux / 100) * $nb_slot,
                'contract_duration_day' => rand(15, 365),
            ]);
        }

        $this->totalSlot = $this->hub->commerce_limit;
        $this->occupiedSlot = $this->hub->commerce_actual;
    }

    public function select(string $societe, int $nb_slot, int $contract_duration, float $ca_prev)
    {
        try {
            if ($nb_slot > $this->totalSlot - $this->occupiedSlot) {
                $this->alert('warning', "Pas assez d'emplacement disponible !");
            } else {
                $this->hub->commerces()->create([
                    'societe' => $societe,
                    'nb_slot_commerce' => $nb_slot,
                    'start_at' => now(),
                    'end_at' => now()->addDays($contract_duration),
                    'ca_daily' => $ca_prev,
                    'user_railway_hub_id' => $this->hub->id
                ]);

                $this->hub->commerce_actual += $nb_slot;
                $this->hub->save();

                $this->alert('success', "Contrat commercial établie");
            }
            $this->dispatch('closeModal', 'modalContracts');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue');
        }

    }

    public function revoque(int $contract_id)
    {
        $this->revoqueContractId = $contract_id;
        $contract = $this->hub->commerces()->find($contract_id);
        $reste_day = now()->diffInDays($contract->end_at);
        $indem = \Helpers::eur($contract->ca_daily * $reste_day);
        $this->alert('question', "Révoquer ce contrat va vous coûtez des indemnités à hauteur de {$indem}, Êtes-vous sur ?", [
            'allowOutsideClick' => false,
            'toast' => false,
            'position' => 'center',
            'timer' => null,
            'showConfirmButton' => true,
            'confirmButtonText' => 'Révoquer le contrat',
            'onConfirmed' => 'confirmed',
            'showCancelButton' => true,
            'cancelButtonText' => 'Annuler',
            'cancelButtonColor' => '#ef5350',
        ]);
    }

    #[On('confirmed')]
    public function confirmRevoque()
    {
        $contract = $this->hub->commerces()->find($this->revoqueContractId);
        $reste_day = now()->diffInDays($contract->end_at);
        $indem = $contract->ca_daily * $reste_day;

        try {
            (new Compta())->create(
                user: auth()->user(),
                title: 'Pénalité pour révocation du contrat commercial: ' . $contract->societe,
                amount: $indem,
                type_amount: 'charger',
                type_mvm: 'commerce',
                valorisation: false,
                user_railway_hub_id: $this->hub->id,
            );

            $this->hub->commerce_actual -= $contract->nb_slot_commerce;
            $this->hub->save();

            $contract->delete();
            $this->alert('success', "Le contrat à été révoqué avec succès");
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', "Une erreur à eu lieu !");
        }
    }
    public function render()
    {
        return view('livewire.game.network.hub-rent-commerce-panel');
    }
}
