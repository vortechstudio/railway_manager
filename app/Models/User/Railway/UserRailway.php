<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Config\RailwayLevel;
use App\Models\Railway\Config\RailwayQuest;
use App\Models\User\User;
use App\Notifications\IncrementReputationNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailway extends Model
{
    public $timestamps = false;

    protected $connection = 'railway';

    protected $guarded = [];
    protected $casts = [
        'automated_planning' => 'boolean',
    ];

    protected $appends = [
        'xp_percent',
        'ranking',
        'next_level_xp',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Retrieves the XP percentage attribute for the model.
     *
     * @return int
     *
     * @throws \Exception
     */
    public function getXpPercentAttribute()
    {
        if ($this->xp == 0) {
            return 0;
        }

        $next_level = RailwayLevel::find($this->level + 1);

        if ($next_level == null) {
            throw new \Exception('Unknown level or not deployed');
        }

        $exp_next_level = $next_level->exp_required;

        if ($exp_next_level == 0) {
            return 0;
        }

        return $this->calculateXpPercent($exp_next_level);
    }

    public function getNextLevelXpAttribute()
    {
        $next_level = RailwayLevel::find($this->level + 1);

        return $next_level->exp_required;
    }

    public function getRankingAttribute()
    {
        foreach (UserRailway::orderBy('reputation', 'desc')->get() as $rank => $userRailway) {
            if ($userRailway->user_id == $this->user_id) {
                return $rank + 1;
            }
        }

        return null;
    }

    /**
     * Calculates the percentage of experience gained towards the next level.
     *
     * @param  int  $exp_next_level  The experience points required for the next level.
     * @return float The percentage of experience gained towards the next level.
     */
    private function calculateXpPercent(int $exp_next_level): float
    {
        $percent_gained = ($this->xp / $exp_next_level) * 100;

        return 100 - $percent_gained;
    }

    public function addReputation(string $type, ?int $model_id)
    {
        $reputation = $this->reputation != 0 ? $this->reputation : 1;
        $coefficient = $this->level != 0 ? $this->level / 100 : 2;

        $new_reputation = match ($type) {
            'engine' => $this->addReputForEngine($coefficient, $reputation),
            'hubs' => $this->addReputForHubs($coefficient, $reputation),
            'ligne' => $this->addReputForLigne($coefficient, $reputation),
            'quest' => $this->addReputForQuest($model_id, $coefficient, $reputation),
            'research' => $this->addReputForResearch($coefficient, $reputation),
        };
        try {
            $this->update([
                'reputation' => $new_reputation,
            ]);
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
        }

        return null;
    }


    private function addReputForEngine(int|float $coefficient, int $reputation)
    {
        $reputation += 200 * $coefficient;

        return $reputation;
    }

    private function addReputForHubs(int|float $coefficient, int $reputation)
    {
        $reputation += 230 * $coefficient;

        return $reputation;
    }

    private function addReputForLigne(int|float $coefficient, int $reputation)
    {
        $reputation += 150 * $coefficient;

        return $reputation;
    }

    private function addReputForResearch(int|float $coefficient, int $reputation)
    {
        $reputation += 100 * $coefficient;

        return $reputation;
    }

    private function addReputForQuest(int $model_id, int|float $coefficient, int $reputation)
    {
        $quest = RailwayQuest::find($model_id);
        $reputation += ($quest->xp_reward / 3.5) * $coefficient;

        return $reputation;
    }
}
