<?php

namespace App\Models\Railway\Config;

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

    public function getImageAttribute()
    {
        return Cache::remember('getImageAttribute:'.$this->name, 1440, function () {
            return Storage::exists('logos/rentals/'.Str::lower($this->name).'.webp') ? Storage::url('logos/rentals/'.Str::lower($this->name).'.webp') : Storage::url('logos/rentals/default.png');
        });
    }
}
