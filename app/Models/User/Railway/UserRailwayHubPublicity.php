<?php

namespace App\Models\User\Railway;

use Illuminate\Database\Eloquent\Model;

class UserRailwayHubPublicity extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    public function userRailwayHub()
    {
        $this->belongsTo(UserRailwayHub::class);
    }
}
