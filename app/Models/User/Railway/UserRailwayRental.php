<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Users\RailwayRentalStatusEnum;
use App\Models\Railway\Config\RailwayRental;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayRental extends Model
{
    public $timestamps = false;

    protected $casts = [
        'date_contract' => 'datetime',
        'status' => RailwayRentalStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function railwayRental(): BelongsTo
    {
        return $this->belongsTo(RailwayRental::class, 'railway_rental_id');
    }

    public function userRailwayEngine(): BelongsTo
    {
        return $this->belongsTo(UserRailwayEngine::class, 'user_railway_engine_id');
    }
}
