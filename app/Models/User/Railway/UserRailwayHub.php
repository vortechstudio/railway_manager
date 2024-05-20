<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Gare\RailwayHub;
use App\Models\Railway\Planning\RailwayIncident;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayHub extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'date_achat' => 'timestamp',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function railwayHub(): BelongsTo
    {
        return $this->belongsTo(RailwayHub::class, 'railway_hub_id');
    }

    public function userRailwayLigne()
    {
        return $this->hasMany(UserRailwayLigne::class);
    }

    public function plannings()
    {
        return $this->hasMany(RailwayPlanning::class);
    }

    public function incidents()
    {
        return $this->hasMany(RailwayIncident::class);
    }
}
