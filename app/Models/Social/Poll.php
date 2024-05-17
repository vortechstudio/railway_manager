<?php

namespace App\Models\Social;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $guarded = [];
    protected $connection = 'mysql';

    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function responses()
    {
        return $this->hasMany(PollResponse::class);
    }
}
