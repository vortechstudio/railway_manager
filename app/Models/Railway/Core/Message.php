<?php

namespace App\Models\Railway\Core;

use App\Enums\Railway\Core\MessageTypeEnum;
use App\Models\User\Railway\UserRailwayMessage;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'message_type' => MessageTypeEnum::class,
    ];

    public function railway_messages()
    {
        return $this->hasMany(UserRailwayMessage::class);
    }
}
