<?php

namespace App\Models\Railway\Engine;

use App\Enums\Railway\Engine\EngineMoneyEnum;
use Illuminate\Database\Eloquent\Model;

class RailwayEngineShop extends Model
{
    protected $guarded = [];

    protected $casts = [
        'money' => EngineMoneyEnum::class,
    ];

    public function engine()
    {
        return $this->belongsTo(RailwayEngine::class);
    }
}
