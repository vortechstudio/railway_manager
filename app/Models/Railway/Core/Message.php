<?php

namespace App\Models\Railway\Core;

use App\Enums\Railway\Core\MessageTypeEnum;
use App\Models\Config\Service;
use App\Models\User\Railway\UserRailwayMessage;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperMessage
 */
class Message extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql';

    protected $guarded = [];

    protected $casts = [
        'message_type' => MessageTypeEnum::class,
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function rewards()
    {
        return $this->hasMany(MessageReward::class);
    }

    public function railway_messages()
    {
        return $this->hasMany(UserRailwayMessage::class);
    }
}
