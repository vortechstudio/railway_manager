<?php

namespace App\Models\Social;

use Illuminate\Database\Eloquent\Model;

class PollResponse extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'users' => 'array',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
