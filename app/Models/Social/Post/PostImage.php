<?php

namespace App\Models\Social\Post;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
