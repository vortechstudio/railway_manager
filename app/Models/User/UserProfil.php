<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserProfil extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'banned_at' => 'timestamp',
        'banned_for' => 'timestamp',
        'birthday' => 'timestamp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
