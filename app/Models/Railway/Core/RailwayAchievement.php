<?php

namespace App\Models\Railway\Core;

use App\Actions\ErrorDispatchHandle;
use App\Enums\Railway\Core\AchievementLevelEnum;
use App\Enums\Railway\Core\AchievementTypeEnum;
use App\Models\User\Railway\UserRailwayAchievement;
use App\Models\User\User;
use App\Notifications\SendMessageAdminNotification;
use App\Services\Models\Railway\Core\RailwayAchievementAction;
use Illuminate\Database\Eloquent\Model;

class RailwayAchievement extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'type' => AchievementTypeEnum::class,
        'level' => AchievementLevelEnum::class,
    ];

    protected $appends = [
        'action_function_exist',
        'icon',
        'icon_type',
    ];

    public function rewards()
    {
        return $this->hasMany(RailwayAchievementReward::class);
    }

    public function getActionFunctionExistAttribute()
    {
        return method_exists(RailwayAchievementAction::class, \Str::camel($this->slug));
    }

    public function getIconAttribute()
    {
        return \Storage::url('icons/railway/success/'.$this->level->value.'.png');
    }

    public function getIconTypeAttribute()
    {
        return \Storage::url('icons/railway/success/'.$this->type->value.'.png');
    }

    public function unlocks()
    {
        return $this->hasMany(UserRailwayAchievement::class);
    }

    public function isUnlockedFor(User $user)
    {
        return $this->unlocks()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function unlockActionFor(User $user, string $action, int $goal = 0)
    {
        try {
            $achievement = $this->newQuery()
                ->where('slug', $action)
                ->where('goal', $goal)
                ->first();

            if ($achievement && ! $achievement->isUnlockedFor($user)) {
                $user->railway_achievements()->create([
                    'user_id' => $user->id,
                    'railway_achievement_id' => $achievement->id,
                ]);

                $this->notifyAchievementUnlock($user);

                return $achievement;
            }

            return null;
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);

            return null;
        }
    }

    public function notifyAchievementUnlock(User $user): void
    {
        if ($this->achievement) {
            $user->notify(new SendMessageAdminNotification(
                title: 'Nouveau succès débloquer !',
                sector: 'alert',
                type: 'success',
                message: 'Un nouveau succès à été débloquer !'
            ));
        }
    }
}
