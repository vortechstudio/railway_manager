<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Users\RailwayDeliveryTypeEnum;
use App\Models\User\User;
use App\Services\Models\User\Railway\UserRailwayDeliveryAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserRailwayDelivery extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'type' => RailwayDeliveryTypeEnum::class,
    ];

    protected $appends = [
        'icon_type',
        'diff_in_second',
    ];

    public function deliverables(): MorphTo
    {
        return $this->morphTo(null, 'model', 'model_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIconTypeAttribute()
    {
        return (new UserRailwayDeliveryAction($this))->getIconOfType();
    }

    public function getDiffInSecondAttribute()
    {
        return (new UserRailwayDeliveryAction($this))->getDiffInSecond();
    }
}
