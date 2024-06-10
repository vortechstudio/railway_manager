<?php

namespace App\Jobs;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Models\User\Railway\UserRailwayEngineTechnicentre;
use App\Services\Models\User\Railway\UserRailwayEngineTechnicentreAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MaintenanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public UserRailwayEngineTechnicentre $engineTechnicentre, public int|float $amountReste)
    {
    }

    public function handle(): void
    {
        try {
            if ($this->engineTechnicentre->exists()) {
                (new UserRailwayEngineTechnicentreAction($this->engineTechnicentre))->delivered();
                (new Compta())->create(
                    user: $this->engineTechnicentre->user,
                    title: 'Maintenance effectuer sur matériel',
                    amount: $this->engineTechnicentre->amount_du,
                    type_amount: 'charge',
                    type_mvm: 'maintenance_engine',
                    valorisation: false,
                    user_railway_ligne_id: $this->engineTechnicentre->userRailwayEngine->userRailwayLigne->id,
                    user_railway_hub_id: $this->engineTechnicentre->userRailwayEngine->userRailwayHub->id,
                );
            } else {
                $this->delete();
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }
}
