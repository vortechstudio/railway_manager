<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Config\RailwayEmpruntTableStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayEmpruntTable extends Model
{
    public $timestamps = false;
    protected $connection = 'railway';
    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
        'status' => RailwayEmpruntTableStatusEnum::class,
    ];

    public function userRailwayEmprunt(): BelongsTo
    {
        return $this->belongsTo(UserRailwayEmprunt::class);
    }
}
