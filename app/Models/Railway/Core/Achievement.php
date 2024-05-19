<?php

namespace App\Models\Railway\Core;

use App\Actions\Railway\AchievementAction;
use App\Enums\Railway\Core\AchievementLevelEnum;
use App\Enums\Railway\Core\AchievementSectorEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'sector' => AchievementSectorEnum::class,
        'level' => AchievementLevelEnum::class,
    ];

    protected $appends = [
        'icon',
        'icon_sector',
        'action_function_exist',
    ];

    public function rewards()
    {
        return $this->belongsToMany(AchieveReward::class, 'achievements_rewards', 'achievement_id', 'reward_id');
    }

    public function getIconAttribute()
    {
        return \Storage::url('icons/railway/success/'.$this->level->value.'.png');
    }

    public function getIconSectorAttribute()
    {
        return \Storage::url('icons/railway/success/'.$this->sector->value.'.png');
    }

    public function getActionFunctionExistAttribute()
    {
        return method_exists(AchievementAction::class, $this->action.'Action');
    }

    public function unlock()
    {
        (new AchievementAction())->handle($this);
    }
}
