<?php

namespace App\Models\User\Railway;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayCompany extends Model
{
    public $timestamps = false;

    protected $connection = 'railway';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mouvements()
    {
        return $this->hasMany(UserRailwayMouvement::class);
    }
}
