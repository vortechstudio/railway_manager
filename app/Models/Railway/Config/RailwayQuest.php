<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRailwayQuest
 */
class RailwayQuest extends Model
{
    public $timestamps = false;

    protected $connection = 'railway';

    protected $guarded = [];
}
