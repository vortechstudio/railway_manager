<?php

namespace App\Livewire\Trophy;

use App\Models\Railway\Core\RailwayAchievement;
use App\Models\User\User;
use App\Services\Models\Railway\Core\RailwayAchievementRewardAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TrophyPanel extends Component
{
    use LivewireAlert;

    public string $sector;

    protected $listeners = ['refreshTrophy' => '$refresh'];

    public function claim(int $achievement_id): void
    {
        $achievement = RailwayAchievement::find($achievement_id);

        foreach ($achievement->rewards as $reward) {
            (new RailwayAchievementRewardAction($reward))->claim();
            auth()->user()->railway_achievements()->where('railway_achievement_id', $achievement_id)->first()->update([
                'reward_claimed_at' => now(),
            ]);
        }

        $this->dispatch('refreshTrophy');
    }

    public function render()
    {
        return view('livewire.trophy.trophy-panel', [
            'countTotalSector' => RailwayAchievement::where('type', $this->sector)->count(),
            'countUserTotalSector' => User::find(auth()->id())->railway_achievements()
                ->with('railwayAchievement')
                ->join('railway_achievements', 'railway_achievements.id', '=', 'user_railway_achievements.railway_achievement_id')
                ->where('railway_achievements.type', $this->sector)
                ->count(),
        ]);
    }
}
