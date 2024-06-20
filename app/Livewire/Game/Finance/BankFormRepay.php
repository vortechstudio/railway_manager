<?php

namespace App\Livewire\Game\Finance;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\CheckoutAction;
use App\Models\User\Railway\UserRailwayEmprunt;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BankFormRepay extends Component
{
    use LivewireAlert;
    public UserRailwayEmprunt $emprunt;
    public int|float $amount_du;
    public int|float $amount_repay;
    public int|float $amount_by_repay;
    public string $typeRepay = 'all';

    public function mount()
    {
        $this->amount_du = $this->emprunt->userRailwayEmpruntTables->where('status', '!=', 'paid')->sum('amount');
        $this->amount_repay = $this->emprunt->amount_emprunt - $this->amount_du;
    }

    public function updated()
    {
        $this->amount_du = $this->emprunt->userRailwayEmpruntTables->where('status', '!=', 'paid')->sum('amount');
        $this->amount_repay = $this->emprunt->amount_emprunt - $this->amount_du;
    }

    public function repay()
    {
        try {
            if($this->typeRepay == 'all') {
                if((new CheckoutAction())->checkoutArgent($this->amount_du)) {
                    (new Compta())->create(
                        user: auth()->user(),
                        title: "Remboursement de l'emprunt N°{$this->emprunt->number}",
                        amount: $this->amount_du,
                        type_amount: 'charge',
                        type_mvm: 'pret',
                    );

                    foreach ($this->emprunt->userRailwayEmpruntTables as $userRailwayEmpruntTable) {
                        $userRailwayEmpruntTable->update([
                            'status' => 'paid'
                        ]);
                    }

                    $this->emprunt->update([
                        'status' => 'terminated'
                    ]);

                    $this->alert('success', "Emprunt N°{$this->emprunt->number} remboursée.");
                } else {
                    $this->alert('error', 'Fonds insuffisants !');
                }
            } else {
                if((new CheckoutAction())->checkoutArgent($this->amount_by_repay)) {
                    (new Compta())->create(
                        user: auth()->user(),
                        title: "Remboursement de l'emprunt N°{$this->emprunt->number}",
                        amount: $this->amount_by_repay,
                        type_amount: 'charge',
                        type_mvm: 'pret',
                    );

                    foreach ($this->emprunt->userRailwayEmpruntTables as $userRailwayEmpruntTable) {
                        $userRailwayEmpruntTable->delete();
                    }

                    $resteTime = $this->emprunt->date->addWeeks($this->emprunt->duration)->diffInWeeks(now());
                    $this->emprunt->update([
                        'amount_hebdo' => ($this->emprunt->amount_emprunt - $this->amount_by_repay) / $resteTime
                    ]);

                    for ($i=1; $i <= $resteTime; $i++) {
                        $this->emprunt->userRailwayEmpruntTables()
                            ->create([
                                'date' => now()->addWeeks($i),
                                'status' => 'planned',
                                'amount' => ($this->emprunt->amount_emprunt - $this->amount_by_repay) / $resteTime,
                                'user_railway_emprunt_id' => $this->emprunt->id,
                            ]);
                    }

                    $this->alert('success', "Emprunt N°{$this->emprunt->number} remboursée à hauteur de {$this->amount_by_repay} €.");
                } else {
                    $this->alert('error', 'Fonds insuffisants !');
                }
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue !');
        }
    }

    public function render()
    {
        return view('livewire.game.finance.bank-form-repay');
    }
}
