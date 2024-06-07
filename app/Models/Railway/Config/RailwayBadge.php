<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperRailwayBadge
 */
class RailwayBadge extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
    ];

    public function rewards()
    {
        return $this->hasMany(RailwayBadgeReward::class);
    }
}
