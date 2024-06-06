<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Core\MessageRewardTypeEnum;
use App\Models\Railway\Core\Message;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperUserRailwayMessage
 */
class UserRailwayMessage extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'reward_type' => MessageRewardTypeEnum::class,
    ];

    public function user(): void
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
        ]);
    }
}
