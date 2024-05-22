<?php

namespace App\Models\Railway\Research;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RailwayResearchProject extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(RailwayResearchCategory::class, 'research_category_id');
    }
}
