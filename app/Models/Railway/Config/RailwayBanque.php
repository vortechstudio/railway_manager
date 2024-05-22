<?php

namespace App\Models\Railway\Config;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Str;

class RailwayBanque extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
    ];

    protected $appends = [
        'image',
        'latest_flux',
    ];

    public function fluxes()
    {
        return $this->hasMany(RailwayBanqueFlux::class);
    }

    public function getImageAttribute()
    {
        return Cache::remember('getImageAttribute:'.$this->name, 1440, function () {
            return Storage::exists('logos/banks/'.Str::lower($this->name).'.webp') ? Storage::url('logos/banks/'.Str::lower($this->name).'.webp') : Storage::url('logos/banks/default.png');
        });
    }

    public function getLatestFluxAttribute()
    {
        return $this->fluxes()->orderBy('date', 'desc')->first();
    }

    /**
     * Generate a new flux record.
     */
    public function generate(): void
    {
        $this->fluxes()->create([
            'date' => now()->startOfDay(),
            'interest' => random_float($this->interest_min, $this->interest_max),
            'railway_banque_id' => $this->id,
        ]);
    }
}
