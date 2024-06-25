<?php

namespace App\Actions\Railway;

use App\Enums\Railway\Config\LevelRewardTypeEnum;
use App\Models\Railway\Config\RailwayLevel;
use App\Models\Railway\Config\RailwayLevelReward;
use App\Models\Railway\Engine\RailwayEngine;

class LevelAction
{
    /**
     * This method handles the generation of rewards and levels for the Vortech Manager application.
     *
     * @param  int  $niv_max  The maximum level to be generated (default: 50).
     * @param  int  $xp_start  The starting experience points for the levels (default: 1250).
     */
    public function handle(int $niv_max = 50, int $xp_start = 1250): void
    {
        $this->generateRewards();
        $this->generateLevels($niv_max, $xp_start);
    }

    /**
     * @var \Illuminate\Support\Collection
     */
    private function generateRewards(): void
    {
        $bases = collect();

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::ARGENT->name),
            'value' => intval(round(rand(1000, 9999), -2, PHP_ROUND_HALF_UP)),

        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::AUDIT_EXT->name),
            'value' => intval(round(rand(2, 10), 0, PHP_ROUND_HALF_UP)),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::AUDIT_INT->name),
            'value' => intval(round(rand(2, 10), 0, PHP_ROUND_HALF_UP)),
        ]);


        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::IMPOT->name),
            'value' => intval(round(rand(1000, 10000), -2, PHP_ROUND_HALF_UP)),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::RD_COAST->name),
            'value' => intval(round(rand(1000, 10000), -2, PHP_ROUND_HALF_UP)),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::RD_RATE->name),
            'value' => round(random_float(0, 0.5), 2, PHP_ROUND_HALF_ODD),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::SIMULATION->name),
            'value' => intval(round(rand(2, 10), 0, PHP_ROUND_HALF_UP)),
        ]);

        $bases->push([
            'type' => \Str::lower(LevelRewardTypeEnum::TPOINT->name),
            'value' => intval(round(rand(5, 20), 2, PHP_ROUND_HALF_UP)),
        ]);

        foreach (RailwayLevelReward::all() as $reward) {
            $reward->delete();
        }

        \DB::connection('railway')->statement('ALTER TABLE `railway_level_rewards` AUTO_INCREMENT = 0;');

        foreach ($bases as $reward) {
            RailwayLevelReward::create([
                'name' => \Str::ucfirst($reward['type']),
                'type' => LevelRewardTypeEnum::tryFrom(\Str::lower($reward['type']))->value,
                'action' => 'reward_'.$reward['type'],
                'action_count' => $reward['value'],
            ]);
        }
    }

    /**
     * Generate railway levels
     *
     * @param  mixed  $niv_max  The maximum level to generate
     * @param  mixed  $xp_start  The starting XP for each level
     */
    private function generateLevels(mixed $niv_max, mixed $xp_start): void
    {
        foreach (RailwayLevel::all() as $level) {
            $level->delete();
        }

        for ($i = 0; $i <= $niv_max; $i++) {
            RailwayLevel::create([
                'id' => $i,
                'exp_required' => $xp_start + ($xp_start * (config('railway.coef_level') * $i)),
                'railway_level_reward_id' => RailwayLevelReward::all()->random()->id,
            ]);
        }
    }
}
