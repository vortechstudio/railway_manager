<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;

class RailwaySetting extends Model
{
    public $timestamps = false;

    protected $connection = 'railway';

    protected $guarded = [];
}
