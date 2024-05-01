<?php

namespace App\Models\Social\Post;

use Illuminate\Database\Eloquent\Model;

class PostCommentReject extends Model
{
    protected $guarded = [];

    public function post_comment()
    {
        return $this->belongsTo(PostComment::class);
    }
}
