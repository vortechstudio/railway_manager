<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Users\RailwayTechnicentreStatusEnum;
use App\Enums\Railway\Users\RailwayTechnicentreTypeEnum;
use App\Models\User\User;
use App\Services\Models\User\Railway\UserRailwayEngineTechnicentreAction;
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

    protected $appends = [
        'type_string',
        'type_label',
        'diff_in_second',
    ];

    public function userRailwayEngine(): BelongsTo
    {
        return $this->belongsTo(UserRailwayEngine::class, 'user_railway_engine_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTypeStringAttribute()
    {
        return (new UserRailwayEngineTechnicentreAction($this))->getTypeStyle('text');
    }

    public function getTypeLabelAttribute()
    {
        $text = (new UserRailwayEngineTechnicentreAction($this))->getTypeStyle('text');
        $color = (new UserRailwayEngineTechnicentreAction($this))->getTypeStyle('color');
        $icon = (new UserRailwayEngineTechnicentreAction($this))->getTypeStyle('icon');

        return "<span class='badge bg-{$color} text-white'><i class='fa-solid {$icon} text-white me-2'></i> {$text}</span>";
    }

    public function getDiffInSecondAttribute()
    {
        return $this->start_at->diffInSeconds($this->end_at);
    }
}
