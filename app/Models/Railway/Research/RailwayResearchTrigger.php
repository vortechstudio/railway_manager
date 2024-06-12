<?php

namespace App\Models\Railway\Research;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayResearchTrigger extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $connection = 'railway';

    public function railwayResearches(): BelongsTo
    {
        return $this->belongsTo(RailwayResearches::class, 'railway_researches_id');
    }
}
