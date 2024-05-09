<?php

namespace App\Models\Railway\Engine;

use Illuminate\Database\Eloquent\Model;

class RailwayEnginePrice extends Model
{
    protected $guarded = [];

    public function engine()
    {
        return $this->belongsTo(RailwayEngine::class);
    }
}
