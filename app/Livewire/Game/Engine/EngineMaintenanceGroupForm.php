<?php

namespace App\Livewire\Game\Engine;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\CheckoutAction;
use App\Jobs\MaintenanceJob;
use App\Livewire\Core\Toolbar;
use App\Services\Models\User\Railway\UserRailwayEngineAction;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class EngineMaintenanceGroupForm extends Component
{
    use LivewireAlert;

    public string $type = '';

    public string $type_string = '';

    public int $selectedUsure = 0;

    public int $selectedAncien = 0;

    public array $selectedEngines = [];

    public int|float $amount_prev = 0;

    public int|float $amount_cur = 0;

    public int|float $totalAmount = 0;

    public $engines;

    public function mount()
    {
        $this->engines = auth()->user()->railway_engines;
    }

    #[On('sliderUsureUpdated')]
    public function usureUpdated($values)
    {
        $this->selectedUsure = intval($values);
        $this->updateEngineList();
    }

    #[On('sliderAncienUpdated')]
    public function ancienUpdate($values)
    {
        $this->selectedAncien = intval($values);
        $this->updateEngineList();
    }

    public function updatedType()
    {
        $this->type_string = match ($this->type) {
            'engine_prev' => 'Maintenance Préventive',
            'engine_cur' => 'Maintenance Curative'
        };
    }

    public function updateEngineList()
    {
        $this->engines = auth()->user()->railway_engines()
            ->when($this->selectedUsure, fn (Builder $query) => $query->where('use_percent', $this->selectedUsure))
            ->when($this->selectedAncien, fn (Builder $query) => $query->where('older', $this->selectedAncien))
            ->get();
    }

    public function updatedSelectedEngines()
    {
        $this->amount_prev = 0;
        $this->amount_cur = 0;
        foreach ($this->selectedEngines as $engine) {
            $eng = auth()->user()->railway_engines()->find($engine);
            $this->amount_prev += (new UserRailwayEngineAction($eng))->getAmountMaintenancePrev();
            $this->amount_cur += (new UserRailwayEngineAction($eng))->getAmountMaintenanceCur();
        }
    }

    public function repair()
    {
        $this->validate([
            'type' => 'required',
        ]);
        $count_select = count($this->selectedEngines);
        $this->totalAmount = match ($this->type) {
            'engine_prev' => $this->amount_prev,
            'engine_cur' => $this->amount_cur,
        };
        $this->alert('question', "Etes vous sûr de vouloir effectuer une {$this->type_string} sur {$count_select} rames pour ".\Helpers::eur($this->totalAmount).' ?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Valider',
            'onConfirmed' => 'confirmed',
            'showCancelButton' => true,
            'cancelButtonText' => 'Annuler',
            'timer' => null,
            'html' => $this->getTableAmount(),
            'width' => '50%',
        ]);
    }

    #[On('confirmed')]
    public function confirmRepair()
    {
        try {
            foreach ($this->selectedEngines as $engine) {
                $eng = auth()->user()->railway_engines()->find($engine);
                $start_at = now();
                $end_at = $eng->railwayEngine->duration_maintenance->diffInMinutes(now());
                $amount_acompte = $this->totalAmount * 30 / 100;

                if(!(new CheckoutAction())->checkoutArgent($amount_acompte)) {
                    $this->alert('error', 'Argent Insuffisant', [
                        'title' => 'Argent Insuffisant',
                        'text' => "Votre Solde ne permet pas le lancement de la maintenance !",
                        'toast' => false,
                        'position' => 'center',
                    ]);
                } else {
                    $tech = $eng->technicentres()->create([
                        'type' => $this->type,
                        'start_at' => $start_at,
                        'end_at' => $start_at->addMinutes($end_at),
                        'user_railway_engine_id' => $engine,
                        'user_id' => auth()->id(),
                        'status' => 'progressed',
                        'amount_du' => $this->totalAmount * 70 / 100,
                    ]);

                    (new Compta())->create(
                        user: auth()->user(),
                        title: 'Acompte sur maintenance',
                        amount: $this->totalAmount * 30 / 100,
                        type_amount: 'charge',
                        type_mvm: 'maintenance_engine',
                        valorisation: false,
                        user_railway_ligne_id: $eng->userRailwayLigne->id,
                        user_railway_hub_id: $eng->userRailwayHub->id,
                    );
                    dispatch(new MaintenanceJob($tech, $this->totalAmount * 70 / 100))->delay($start_at->addMinutes($end_at));
                    $this->alert('success', 'La maintenance des rames à bien été programmer');
                    $this->redirectRoute('technicentre.index');
                    $this->dispatch('refreshComponent')->to(EngineMaintenance::class);
                    $this->dispatch('refreshToolbar')->to(Toolbar::class);
                    $this->dispatch('closeModal', 'repair');
                }
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue !');
        }
    }

    public function getTableAmount()
    {
        ob_start();
        ?>
        <table
            class="table table-bordered table-striped bg-blue-500 text-light rounded-4 gap-5 gs-5 gy-5 gx-5 align-middle">
            <tbody>
            <tr>
                <td class="w-25">Montant Total</td>
                <td><?= \Helpers::eur($this->totalAmount) ?></td>
            </tr>
            <tr>
                <td class="w-25">Acompte</td>
                <td><?= \Helpers::eur($this->totalAmount * 30 / 100) ?></td>
            </tr>
            <tr>
                <td class="w-25">Regler à la fin de maintenance</td>
                <td><?= \Helpers::eur($this->totalAmount * 70 / 100) ?></td>
            </tr>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }

    public function render()
    {
        return view('livewire.game.engine.engine-maintenance-group-form');
    }
}
