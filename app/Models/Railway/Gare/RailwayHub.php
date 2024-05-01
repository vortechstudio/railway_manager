<?php

namespace App\Models\Railway\Gare;

use App\Enums\Railway\Gare\HubStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Settings\Traits\Settingable;

class RailwayHub extends Model
{
    use Settingable;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'status' => HubStatusEnum::class,
    ];

    public function gare()
    {
        return $this->belongsTo(RailwayGare::class, 'gare_id');
    }
}
