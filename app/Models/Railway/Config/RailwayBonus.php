<?php

namespace App\Models\Railway\Config;

use App\Enums\Railway\Config\BonusTypeEnum;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Storage;

class RailwayBonus extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'type' => BonusTypeEnum::class,
    ];

    protected $appends = [
        'icon',
    ];

    public function getIconAttribute()
    {
        return Cache::remember('getImageAttribute:'.$this->designation, 1440, function () {
            return Storage::exists('icons/bonus/'.$this->type->value.'.png') ? Storage::url('icons/bonus/'.$this->type->value.'.png') : Storage::url('icons/bonus/argent.png');
        });
    }

    public static function generateValueFromType(string $type)
    {
        return match ($type) {
            'argent' => round(generateRandomFloat(10000, 900000), -3, PHP_ROUND_HALF_UP),
            default => random_int(1, 50)
        };
    }

    public static function generateDesignationFromType(string $type, int $value): string
    {
        return match ($type) {
            'argent' => "+ $value €",
            'tpoint' => "+ $value",
            'simulation' => "+ $value ".\Str::plural('simulation', $value),
            'audit_int' => "+ $value ".\Str::plural('audit', $value).' '.\Str::plural('interne', $value),
            'audit_ext' => "+ $value ".\Str::plural('audit', $value).' '.\Str::plural('externe', $value),
            'research' => "+ $value ".\Str::plural('recherche', $value),
        };
    }
}
