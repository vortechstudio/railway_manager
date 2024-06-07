<?php

namespace App\Models\Railway\Core;

use App\Enums\Config\MessageRewardTypeEnum;
use Illuminate\Database\Eloquent\Model;

class MessageReward extends Model
{
    protected $connection = 'mysql';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'reward_type' => MessageRewardTypeEnum::class,
    ];

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }
}
