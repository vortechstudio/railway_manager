<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperUserSocial
 */
class UserSocial extends Model
{
    protected $guarded = [];

    protected $connection = 'mysql';

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
