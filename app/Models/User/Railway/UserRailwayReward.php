<?php

namespace App\Models\User\Railway;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperUserRailwayReward
 */
class UserRailwayReward extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    public function reward()
    {
        return $this->morphTo('model', null, 'model_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
