<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Users\RailwayTechnicentreStatusEnum;
use App\Enums\Railway\Users\RailwayTechnicentreTypeEnum;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayEngineTechnicentre extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $connection = 'railway';

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'type' => RailwayTechnicentreTypeEnum::class,
        'status' => RailwayTechnicentreStatusEnum::class,
    ];

    public function userRailwayEngine(): BelongsTo
    {
        return $this->belongsTo(UserRailwayEngine::class, 'user_railway_engine_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
