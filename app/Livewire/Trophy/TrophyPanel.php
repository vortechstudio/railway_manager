<?php

namespace App\Livewire\Trophy;

use App\Models\Railway\Core\Achievement;
use App\Models\User\User;
use Livewire\Component;

class TrophyPanel extends Component
{
    public string $sector;
    public function render()
    {
        return view('livewire.trophy.trophy-panel', [
            'countTotalSector' => Achievement::where('sector', $this->sector)->count(),
            'countUserTotalSector' => User::find(9)->railway_achievements()
                ->with('achievement')
                ->join('achievements', 'achievements.id', '=', 'user_railway_achievements.achievement_id')
                ->where('achievements.sector', $this->sector)
                ->count(),
        ]);
    }
}
