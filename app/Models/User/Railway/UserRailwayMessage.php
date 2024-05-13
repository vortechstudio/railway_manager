<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Core\Message;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class UserRailwayMessage extends Model
{
    protected $guarded = [];

    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
        ]);
    }
}
