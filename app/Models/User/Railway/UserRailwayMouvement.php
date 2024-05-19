<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Core\MvmTypeAmountEnum;
use App\Enums\Railway\Core\MvmTypeMvmEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayMouvement extends Model
{
    public $timestamps = false;
    protected $connection = 'railway';
    protected $guarded = [];

    protected $casts = [
        'type_amount' => MvmTypeAmountEnum::class,
        'type_mvm' => MvmTypeMvmEnum::class,
    ];

    public function userRailwayCompany(): BelongsTo
    {
        return $this->belongsTo(UserRailwayCompany::class, 'user_railway_company_id');
    }
}
