<?php

namespace App\Livewire\Account;

use App\Actions\Railway\EngineAction;
use App\Models\Railway\Config\RailwayLevel;
use App\Models\Railway\Config\RailwayLevelReward;
use App\Models\User\User;
use App\Services\Models\Railway\Engine\RailwayEngineAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class LevelingTable extends Component
{
    use LivewireAlert;

    public User $user;

    public function mount(): void
    {
        $this->user = User::find(auth()->id());
    }

    public function claim(int $level_id): void
    {
        $level = RailwayLevel::find($level_id);
        if ($level->id >= $this->user->railway->level) {
            $this->alert('error', 'Vous ne pouvez-pas recupérer cette récompense actuellement !');
        }
        match ($level->reward->type->value) {
            'argent' => $this->rewardArgent($level->reward),
            'audit_int' => $this->rewardAuditInt($level->reward),
            'audit_ext' => $this->rewardAuditExt($level->reward),
            'engine' => $this->rewardEngine($level->reward),
            'engine_r' => $this->rewardEngineReskin($level->reward),
            'impot' => $this->rewardImpot($level->reward),
            'rd_coast' => $this->rewardRdCoast($level->reward),
            'rd_rate' => $this->rewardRdRate($level->reward),
            'simulation' => $this->rewardSimulation($level->reward),
            'tpoint' => $this->rewardTpoint($level->reward),
        };

        $this->user->railway_rewards()->create([
            'user_id' => $this->user->id,
            'model' => RailwayLevelReward::class,
            'model_id' => $level->reward->id,
        ]);

        $this->alert('success', 'Récompense récupérée', [
            'html' => $this->blockReward($level->reward),
            'toast' => false,
            'allowOutsideClick' => true,
            'timer' => null,
            'position' => 'center',
        ]);
    }

    public function rewardArgent(RailwayLevelReward $reward): void
    {
        $this->user->railway->argent += $reward->action_count;
        $this->user->railway->save();
    }

    public function rewardAuditInt(RailwayLevelReward $reward): void
    {
        $this->user->railway_bonus->audit_int += $reward->action_count;
        $this->user->railway_bonus->save();
    }

    public function rewardAuditExt(RailwayLevelReward $reward): void
    {
        $this->user->railway_bonus->audit_ext += $reward->action_count;
        $this->user->railway_bonus->save();
    }

    public function rewardEngine(RailwayLevelReward $reward): void
    {
        $engine = $reward->model::find($reward->model_id);

        $this->user->railway_engines()->create([
            'number' => (new EngineAction())->generateMissionCode($engine, $this->user->userRailwayHub()->first()),
            'max_runtime' => (new RailwayEngineAction($engine))->maxRuntime(),
            'available' => true,
            'date_achat' => now(),
            'status' => 'free',
            'user_id' => $this->user->id,
            'railway_engine_id' => $engine->id,
            'user_railway_hub_id' => $this->user->userRailwayHub()->first()->id,
            'active' => true,
        ]);
    }

    public function rewardEngineReskin(RailwayLevelReward $reward)
    {
    }

    public function rewardImpot(RailwayLevelReward $reward): void
    {
        $this->user->railway_company->credit_impot += $reward->action_count;
        $this->user->railway_company->save();
    }

    public function rewardRdCoast(RailwayLevelReward $reward): void
    {
        $this->user->railway->research += $reward->action_count;
        $this->user->railway->save();
    }

    public function rewardRdRate(RailwayLevelReward $reward): void
    {
        $this->user->railway_company->rate_research += $reward->action_count;
        $this->user->railway_company->save();
    }

    public function rewardSimulation(RailwayLevelReward $reward): void
    {
        $this->user->railway_bonus->simulation += $reward->action_count;
        $this->user->railway_bonus->save();
    }

    public function rewardTpoint(RailwayLevelReward $reward): void
    {
        $this->user->railway->tpoint += $reward->action_count;
        $this->user->railway->save();
    }

    public function blockReward($reward)
    {
        $html = "<div class='d-flex flex-wrap justify-content-center align-items-center w-100 mx-auto gap-5 my-5'>";

        $html .= "<div class='d-flex flex-wrap justify-content-center align-items-center'>";
        $html .= "<div class='symbol symbol-150px border border-primary p-5 mb-2 animate__animated animate__flipInX animate__delay-1s'>";
        $html .= "<img class='' src='".\Storage::url("icons/railway/{$reward->type->value}.png")."' alt=''>";
        $html .= '</div>';
        $html .= "<span class='badge badge-lg badge-light animate__animated animate__fadeInDown animate__delay-1s'>".htmlspecialchars($reward->action_count).'</span>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    public function render()
    {
        return view('livewire.account.leveling-table');
    }
}
