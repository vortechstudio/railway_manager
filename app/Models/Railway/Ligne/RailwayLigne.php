<?php

namespace App\Models\Railway\Ligne;

use App\Enums\Railway\Ligne\LigneStatusEnum;
use App\Enums\Railway\Ligne\LigneTypeEnum;
use App\Models\Railway\Gare\RailwayGare;
use App\Models\Railway\Gare\RailwayHub;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Settings\Traits\Settingable;

class RailwayLigne extends Model
{
    use Settingable, SoftDeletes;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'status' => LigneStatusEnum::class,
        'type' => LigneTypeEnum::class,
    ];

    public function start()
    {
        return $this->belongsTo(RailwayGare::class, 'start_gare_id');
    }

    public function end()
    {
        return $this->belongsTo(RailwayGare::class, 'end_gare_id');
    }

    public function hub()
    {
        return $this->belongsTo(RailwayHub::class, 'hub_id');
    }

    public function stations()
    {
        return $this->hasMany(RailwayLigneStation::class);
    }
}
