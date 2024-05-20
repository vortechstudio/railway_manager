<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Users\RailwayDeliveryTypeEnum;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserRailwayDelivery extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'start_at' => 'timestamp',
        'end_at' => 'timestamp',
        'type' => RailwayDeliveryTypeEnum::class,
    ];

    public function deliverables(): MorphTo
    {
        return $this->morphTo(null, 'model', 'model_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
