<?php

namespace App\Models\Railway\Config;

use App\Enums\Railway\Config\BonusTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RailwayBonus extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'type' => BonusTypeEnum::class,
    ];
}
