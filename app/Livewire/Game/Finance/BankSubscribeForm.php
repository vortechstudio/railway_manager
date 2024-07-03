<?php

namespace App\Livewire\Game\Finance;

use App\Actions\Compta;
use App\Livewire\Core\Toolbar;
use App\Models\Railway\Config\RailwayBanque;
use App\Models\User\Railway\UserRailwayEmprunt;
use App\Services\Models\User\Railway\UserRailwayEmpruntAction;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BankSubscribeForm extends Component
{
    use LivewireAlert;
    //Form
    public ?int $selectedBank = null;
    public ?string $typeEmprunt = null;
    public int|float $amountRequest;
    public int $empruntDuration;
    public int|float $croissance;

    // Calcule
    public int|float $charge;
    public int|float $amountTotal;
    public int|float $amountHebdo;
    public RailwayBanque $bq;

    public function updatedSelectedBank()
    {
        $this->bq = RailwayBanque::find($this->selectedBank);
        $this->dispatch('updatedForm', 'select2');
    }

    public function updatedAmountRequest()
    {
        if($this->typeEmprunt == 'express') {
            $pending = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'express')->where('status', 'pending')->where('railway_banque_id', $this->bq->id)->sum('amount_emprunt');
            $charge = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'express')->where('status', 'pending')->where('railway_banque_id', $this->bq->id)->sum('charge');
            $reste = $this->bq->express_base - ($pending - $charge);
        } else {
            $pending = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'marche')->where('status', 'pending')->where('railway_banque_id', $this->bq->id)->sum('amount_emprunt');
            $charge = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'marche')->where('status', 'pending')->where('railway_banque_id', $this->bq->id)->sum('charge');
            $reste = $this->bq->public_base - ($pending - $charge);
        }
        if($this->amountRequest > $reste) {
            $this->amountRequest = $reste;
        }
    }

    public function updatedEmpruntDuration()
    {
        $this->charge = ($this->amountRequest * $this->bq->latest_flux / 100) * $this->empruntDuration;
        $this->amountTotal = $this->amountRequest + $this->charge;
        $this->amountHebdo = $this->amountTotal / $this->empruntDuration;
    }

    public function subscribe()
    {
        if($this->typeEmprunt == 'express') {
            $pret = auth()->user()->railway->userRailwayEmprunts()->create([
                'number' => \Helpers::randomNumerique(9),
                'type_emprunt' => 'express',
                'date' => Carbon::today(),
                'amount_emprunt' => $this->amountTotal,
                'taux_emprunt' => $this->bq->latest_flux,
                'charge' => $this->charge,
                'duration' => $this->empruntDuration,
                'amount_hebdo' => $this->amountHebdo,
                'status' => 'pending',
                'railway_banque_id' => $this->bq->id,
                'user_railway_id' => auth()->user()->railway->id,
            ]);

            (new Compta())->create(
                user: auth()->user(),
                title: "Emprunt Express {$pret->number} du {$pret->date->format('d/m/Y')}",
                amount: $this->amountRequest,
                type_amount: 'revenue',
                type_mvm: 'pret',
            );

            for ($i = 1; $i <= $this->empruntDuration; $i++) {
                $pret->userRailwayEmpruntTables()->create([
                    'date' => now()->addWeeks($i)->startOfDay(),
                    'amount' => $this->amountHebdo,
                    'status' => 'planned',
                    'user_railway_emprunt_id' => $pret->id
                ]);
            }
            $this->alert('success', "Votre pret {$pret->number} à été créer avec succès");
            $this->dispatch('refreshToolbar')->to(Toolbar::class);
        } else {
            $pret = UserRailwayEmprunt::create([
                'number' => \Helpers::randomNumerique(9),
                'type_emprunt' => 'marche',
                'date' => Carbon::today(),
                'amount_emprunt' => $this->amountTotal,
                'taux_emprunt' => (new UserRailwayEmpruntAction())->getLatestFluxOfMarket($this->bq, auth()->user()->railway),
                'charge' => $this->charge,
                'duration' => $this->empruntDuration,
                'amount_hebdo' => $this->amountHebdo,
                'status' => 'pending',
                'railway_banque_id' => $this->bq->id,
                'croissance' => $this->croissance,
                'user_railway_id' => auth()->user()->railway->id,
            ]);

            for ($i = 1; $i < $this->empruntDuration; $i++) {
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
                amount: $this->amountRequest,
                type_amount: 'revenue',
                type_mvm: 'pret',
            );
            $this->alert('success', "Votre pret {$pret->number} à été créer avec succès");
            $this->dispatch('refreshToolbar')->to(Toolbar::class);
        }
    }

    public function render()
    {
        return view('livewire.game.finance.bank-subscribe-form');
    }
}
