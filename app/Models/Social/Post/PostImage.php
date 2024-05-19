<?php

namespace App\Models\Social\Post;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $guarded = [];
    protected $connection = 'mysql';

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
