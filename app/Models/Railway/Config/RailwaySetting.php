<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRailwaySetting
 */
class RailwaySetting extends Model
{
    public $timestamps = false;

    protected $connection = 'railway';

    protected $guarded = [];
}
