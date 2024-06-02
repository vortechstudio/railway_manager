<?php

namespace App\Models\Railway\Engine;

use App\Services\Models\Railway\Engine\RailwayEnginePriceAction;
use Illuminate\Database\Eloquent\Model;

class RailwayEnginePrice extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    protected $appends = [
        'amount_caution'
    ];

    public function engine()
    {
        return $this->belongsTo(RailwayEngine::class, 'railway_engine_id');
    }

    public function getAmountCautionAttribute()
    {
        return (new RailwayEnginePriceAction($this))->calcCaution();
    }
}
