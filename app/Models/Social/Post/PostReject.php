<?php

namespace App\Models\Social\Post;

use Illuminate\Database\Eloquent\Model;

class PostReject extends Model
{
    protected $guarded = [];

    protected $connection = 'mysql';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
