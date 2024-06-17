<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Users\RailwayEmpruntTypeEnum;
use App\Models\Railway\Config\RailwayBanque;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayEmprunt extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';

    protected $casts = [
        'date' => 'datetime',
        'type_emprunt' => RailwayEmpruntTypeEnum::class,
    ];

    public function railwayBanque(): BelongsTo
    {
        return $this->belongsTo(RailwayBanque::class);
    }

    public function userRailway()
    {
        return $this->belongsTo(UserRailway::class);
    }
}
