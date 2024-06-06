<?php

namespace App\Models\Railway\Research;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRailwayResearchCategory
 */
class RailwayResearchCategory extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;
}
