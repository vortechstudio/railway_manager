<?php

namespace App\Jobs;

use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\ResearchTrigger\AccessFret;
use App\Actions\Railway\ResearchTrigger\ResearchConvBas;
use App\Actions\Railway\ResearchTrigger\ResearchConvRud;
use App\Actions\Railway\ResearchTrigger\UpdateDistraction;
use App\Models\Railway\Research\RailwayResearches;
use App\Models\User\Railway\UserRailway;
use App\Models\User\Railway\UserResearchDelivery;
use App\Models\User\ResearchUser;
use App\Notifications\SendMessageAdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResearchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public UserResearchDelivery $delivery, public RailwayResearches $researches, public ResearchUser $researchUser)
    {
    }

    public function handle(): void
    {
        try {
            if ($this->delivery->exists()) {
                $trigger = $this->researches->triggers()->where('action_count', $this->researchUser->current_level)->first();
                match ($trigger->action) {
                    'accessFret' => (new AccessFret())->handle(),
                    'researchConvRud' => (new ResearchConvRud())->handle($trigger, $this->researchUser->current_level),
                    'researchConvBase' => (new ResearchConvBas())->handle($trigger, $this->researchUser->current_level),
                    'updateDistraction' => (new UpdateDistraction())->handle($trigger, $this->researchUser->current_level),
                };
                $railway = new UserRailway();
                $railway->find($this->researchUser->user_railway_id)->addReputation('research', null);
                $this->nextChild();
                $railway->find($this->researchUser->user_railway_id)
                    ->user
                    ->notify(new SendMessageAdminNotification(
                        title: 'Nouvelle recherche débloquer',
                        sector: 'alert',
                        type: 'success',
                        message: "La recherche {$this->researches->name} à été débloquer"
                    ));
            } else {
                $this->delete();
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    private function nextChild()
    {
        if ($this->researchUser->current_level == $this->researches->level) {
            $child = $this->researches->childrens()->first();
            ResearchUser::where('railway_research_id', $child->id)
                ->where('user_railway_id', $this->researchUser->user_railway_id)
                ->first()
                ->update([
                    'is_unlocked' => true,
                ]);
        }
    }
}
