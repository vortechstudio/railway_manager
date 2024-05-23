<?php

namespace App\Models\Railway\Config;

use App\Enums\Railway\Config\AdvantageCardClassEnum;
use App\Enums\Railway\Config\AdvantageCardTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RailwayAdvantageCard extends Model
{
    use SoftDeletes;

    protected $connection = 'railway';

    protected $guarded = [];

    protected $casts = [
        'class' => AdvantageCardClassEnum::class,
        'type' => AdvantageCardTypeEnum::class,
    ];
}
