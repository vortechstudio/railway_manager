<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSocial extends Model
{
    protected $guarded = [];

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
