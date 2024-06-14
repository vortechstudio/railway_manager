<?php

namespace App\Models\User\Railway;

use App\Models\User\User;
use App\Services\Models\User\Railway\UserRailwayCompanyAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayCompany extends Model
{
    public $timestamps = false;

    protected $connection = 'railway';

    protected $guarded = [];

    protected $appends = [
        'distract_level_coef',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mouvements()
    {
        return $this->hasMany(UserRailwayMouvement::class);
    }

    public function getDistractLevelCoefAttribute()
    {
        return (new UserRailwayCompanyAction($this))->getDistractCoefOfLevel();
    }
}
