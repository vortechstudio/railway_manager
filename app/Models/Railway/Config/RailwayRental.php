<?php

namespace App\Models\Railway\Config;

use App\Models\Railway\Engine\RailwayEngine;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Str;

class RailwayRental extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
        'type' => 'array',
    ];

    protected $appends = [
        'image',
    ];

    public function engines()
    {
        return $this->belongsToMany(RailwayEngine::class, 'railway_engine_rentals', 'railway_engine_id', 'railway_rental_id');
    }

    public function getImageAttribute()
    {
        return Cache::remember('getImageAttribute:'.$this->name, 1440, function () {
            return Storage::exists('logos/rentals/'.Str::lower($this->name).'.webp') ? Storage::url('logos/rentals/'.Str::lower($this->name).'.webp') : Storage::url('logos/rentals/default.png');
        });
    }
}
