<?php

namespace App\Livewire\Game\Finance;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Livewire\Core\Toolbar;
use App\Models\Railway\Config\RailwayBanque;
use App\Models\User\Railway\UserRailwayEmprunt;
use App\Services\Models\User\Railway\UserRailwayEmpruntAction;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class BankFormMarket extends Component
{
    use LivewireAlert;
    public RailwayBanque $banque;

    // form
    public int $duration_emprunt;
    public int|float $amount_request;
    public int|float $croissance;


    // calcul
    public int|float $charge;
    public int|float $amountTotal;
    public int|float $amountHebdo;

    public function save()
    {
        $this->charge = ($this->amount_request * (new UserRailwayEmpruntAction())->getLatestFluxOfMarket($this->banque, auth()->user()->railway) / 100) * $this->duration_emprunt;
        $this->amountTotal = $this->amount_request + $this->charge;
        $this->amountHebdo = $this->amountTotal / $this->duration_emprunt;
        $this->alert('question', "Estimation de l'offre d'emprunt", [
            'toast' => false,
            'width' => '50%',
            'position' => 'center',
            'timer' => null,
            'allowOutsideClick' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'Valider',
            'onConfirmed' => 'confirmed',
            'showCancelButton' => true,
            'cancelButtonText' => 'Annuler',
            'cancelButtonColor' => '#ef5350',
            'html' => $this->getEstimateInfo()
        ]);
    }

    #[On('confirmed')]
    public function confirmed()
    {
        try {
            if($this->amount_request > $this->banque->public_base) {
                $this->alert('warning', "Montant supérieur à la limite autorisé");
            } elseif($this->amount_request > auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'marche')->sum('amount_emprunt')) {
                $this->alert('error', 'Limite de prêt express atteinte !');
            } else {
                $pret = UserRailwayEmprunt::create([
                    'number' => \Helpers::randomNumerique(9),
                    'type_emprunt' => 'marche',
                    'date' => Carbon::today(),
                    'amount_emprunt' => $this->amountTotal,
                    'taux_emprunt' => (new UserRailwayEmpruntAction())->getLatestFluxOfMarket($this->banque, auth()->user()->railway),
                    'charge' => $this->charge,
                    'duration' => $this->duration_emprunt,
                    'amount_hebdo' => $this->amountHebdo,
                    'status' => 'pending',
                    'railway_banque_id' => $this->banque->id,
                    'croissance' => $this->croissance,
                    'user_railway_id' => auth()->user()->railway->id,
                ]);

                for ($i = 1; $i < $this->duration_emprunt; $i++) {
                    $pret->userRailwayEmpruntTables()->create([
                        'date' => now()->addWeeks($i)->startOfDay(),
                        'amount' => $this->amountHebdo,
                        'status' => 'planned',
                        'user_railway_emprunt_id' => $pret->id
                    ]);
                }

                (new Compta())->create(
                    user: auth()->user(),
                    title: "Emprunt sur les marchés financiers N° {$pret->number} du {$pret->date->format('d/m/Y')}",
                    amount: $this->amount_request,
                    type_amount: 'revenue',
                    type_mvm: 'pret',
                );
                $this->alert('success', "Votre pret {$pret->number} à été créer avec succès");
                $this->dispatch('refresh')->to(BankCard::class);
                $this->dispatch('refreshToolbar')->to(Toolbar::class);
            }

            $this->dispatch('closeModal', 'express');

        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue !');
        }
    }

    public function render()
    {
        return view('livewire.game.finance.bank-form-market');
    }

    private function getEstimateInfo(): bool|string
    {
        ob_start();
        ?>
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center bg-gray-200 rounded-2 p-5 mb-1">
                <span>Somme demandée</span>
                <span><?= \Helpers::eur($this->amount_request) ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center bg-gray-200 rounded-2 p-5 mb-1">
                <span>Taux Hebdomadaire</span>
                <span><?= (new UserRailwayEmpruntAction())->getLatestFluxOfMarket($this->banque, auth()->user()->railway) ?> %</span>
            </div>
            <div class="d-flex justify-content-between align-items-center bg-gray-200 rounded-2 p-5 mb-1">
                <span>Charge Financière</span>
                <span><?= \Helpers::eur($this->charge) ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center bg-gray-200 rounded-2 p-5 mb-1">
                <span>Coût Total du prêt</span>
                <span><?= \Helpers::eur($this->amountTotal) ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center bg-gray-200 rounded-2 p-5 mb-1">
                <span>Paiement Hebdomadaire</span>
                <span><?= \Helpers::eur($this->amountHebdo) ?></span>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
