<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $guarded = [];
    protected $connection = 'mysql';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
