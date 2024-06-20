<?php

namespace App\Livewire\Game\Finance;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Livewire\Core\Toolbar;
use App\Models\Railway\Config\RailwayBanque;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class BankFormExpress extends Component
{
    use LivewireAlert;

    public RailwayBanque $banque;

    // Form
    public int $amount_request;
    public int $emprunt_duration;

    public int|float $charge;
    public int|float $amountTotal;
    public int|float $amountHebdo;

    public function save()
    {
        $this->charge = ($this->amount_request * $this->banque->latest_flux / 100) * $this->emprunt_duration;
        $this->amountTotal = $this->amount_request + $this->charge;
        $this->amountHebdo = $this->amountTotal / $this->emprunt_duration;

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
            $pending = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'express')->where('railway_banque_id', $this->banque->id)->where('status', '!=', 'terminated')->sum('amount_emprunt');
            $reste = $this->banque->express_base - $pending;

            if ($this->amount_request > $this->banque->express_base) {
                $this->alert('warning', "Montant supérieur à la limite autorisé");
            } elseif ($this->amount_request > $reste) {
                $this->alert('error', 'Limite de prêt express atteinte !');
            } else {
                $pret = auth()->user()->railway->userRailwayEmprunts()->create([
                    'number' => \Helpers::randomNumerique(9),
                    'type_emprunt' => 'express',
                    'date' => Carbon::today(),
                    'amount_emprunt' => $this->amountTotal,
                    'taux_emprunt' => $this->banque->latest_flux,
                    'charge' => $this->charge,
                    'duration' => $this->emprunt_duration,
                    'amount_hebdo' => $this->amountHebdo,
                    'status' => 'pending',
                    'railway_banque_id' => $this->banque->id,
                    'user_railway_id' => auth()->user()->railway->id,
                ]);

                (new Compta())->create(
                    user: auth()->user(),
                    title: "Emprunt Express {$pret->number} du {$pret->date->format('d/m/Y')}",
                    amount: $this->amount_request,
                    type_amount: 'revenue',
                    type_mvm: 'pret',
                );

                for ($i = 1; $i <= $this->emprunt_duration; $i++) {
                    $pret->userRailwayEmpruntTables()->create([
                        'date' => now()->addWeeks($i)->startOfDay(),
                        'amount' => $this->amountHebdo,
                        'status' => 'planned',
                        'user_railway_emprunt_id' => $pret->id
                    ]);
                }

                $this->alert('success', "Votre pret {$pret->number} à été créer avec succès");
                $this->dispatch('refresh')->to(BankCard::class);
                $this->dispatch('refreshToolbar')->to(Toolbar::class);
            }
            $this->dispatch('closeModal', 'express');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function render()
    {
        return view('livewire.game.finance.bank-form-express');
    }

    private function getEstimateInfo(): bool|string
    {
        ob_start();
        ?>
        <p>Notre banquier accepte de vous prêter cette somme pour un taux hebdomadaire s'élevant à
            <strong><?= $this->banque->latest_flux ?> %</strong></p>
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center bg-gray-200 rounded-2 p-5 mb-1">
                <span>Somme demandée</span>
                <span><?= \Helpers::eur($this->amount_request) ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center bg-gray-200 rounded-2 p-5 mb-1">
                <span>Taux Hebdomadaire</span>
                <span><?= $this->banque->latest_flux ?></span>
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
