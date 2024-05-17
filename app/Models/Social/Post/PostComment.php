<?php

namespace App\Models\Social\Post;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $connection = 'mysql';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reject()
    {
        return $this->hasOne(PostCommentReject::class);
    }
}
