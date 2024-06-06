<?php

namespace App\Models\Social;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPollResponse
 */
class PollResponse extends Model
{
    protected $guarded = [];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $casts = [
        'users' => 'array',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
