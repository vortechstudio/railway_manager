<?php

namespace App\Models\Railway\Engine;

use Illuminate\Database\Eloquent\Model;

class RailwayEnginePrice extends Model
{
    protected $guarded = [];
    protected $connection = 'railway';

    public function engine()
    {
        return $this->belongsTo(RailwayEngine::class, 'railway_engine_id');
    }
}
