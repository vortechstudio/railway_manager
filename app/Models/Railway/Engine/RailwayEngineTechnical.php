<?php

namespace App\Models\Railway\Engine;

use App\Enums\Railway\Engine\EngineTechMarchEnum;
use App\Enums\Railway\Engine\EngineTechMotorEnum;
use Illuminate\Database\Eloquent\Model;

class RailwayEngineTechnical extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    protected $casts = [
        'motor' => EngineTechMotorEnum::class,
        'marchandise' => EngineTechMarchEnum::class,
    ];

    public function engine()
    {
        return $this->belongsTo(RailwayEngine::class, 'railway_engine_id');
    }
}
