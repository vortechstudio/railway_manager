<?php

namespace App\Livewire\Game\Planning;

use Livewire\Component;

class PlanningTimeline extends Component
{
    public $datas;
    public $plannings;


    public function mount()
    {
        $this->datas = auth()->user()->railway_plannings()->whereBetween('date_depart', [now()->startOfDay(), now()->endOfDay()])->get();

        foreach ($this->datas as $data) {
            ob_start();
            ?>
            <div class="d-flex flex-column w-300px rounded-2 bg-white p-10">
                <div class="d-flex flex-row align-items-center">
                    <div class="symbol symbol-20px me-2">
                        <img src="<?= $data->userRailwayLigne->railwayLigne->icon  ?>" alt="">
                    </div>
                    <div class="fw-bolder"><?= $data->userRailwayLigne->railwayLigne->name ?></div>
                </div>
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row">
                        <div class="fw-bolder">Départ:</div>
                        <div class="ms-auto"><?= $data->date_depart->format('H:i') ?></div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="fw-bolder">Arrivée:</div>
                        <div
                            class="ms-auto"><?= $data->date_depart->addMinutes($data->userRailwayLigne->railwayLigne->time_min)->format('H:i') ?></div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="fw-bolder">Etat:</div>
                        <div class="ms-auto"><?= $data->status->value ?></div>
                    </div>
                </div>
            </div>
            <?php
            $tooltip = ob_get_clean();
            $this->plannings[] = [
                $data->userRailwayEngine->railwayEngine->name,
                $data->userRailwayEngine->railwayEngine->type_transport->name.' - N°'.$data->number_travel,
                $tooltip,
                $data->date_depart,
                $data->date_arrived,
            ];
        }

        $this->plannings = json_encode($this->plannings);
    }

    public function render()
    {
        return view('livewire.game.planning.planning-timeline');
    }
}
