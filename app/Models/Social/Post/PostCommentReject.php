<?php

namespace App\Models\Social\Post;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPostCommentReject
 */
class PostCommentReject extends Model
{
    protected $guarded = [];

    protected $connection = 'mysql';

    public function post_comment()
    {
        return $this->belongsTo(PostComment::class);
    }
}
