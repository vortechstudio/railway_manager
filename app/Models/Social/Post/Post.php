<?php

namespace App\Models\Social\Post;

use App\Enums\Social\Post\PostTypeEnum;
use App\Enums\Social\Post\PostVisibilityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Taggable\Traits\Taggable;

class Post extends Model
{
    protected $guarded = [];

    use SoftDeletes, Taggable;

    protected $casts = [
        'published' => 'boolean',
        'commentable' => 'boolean',
        'visibility' => PostVisibilityEnum::class,
        'type' => PostTypeEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\Social\Post\PostImage::class);
    }

    public function reject()
    {
        return $this->hasOne(\App\Models\Social\Post\PostReject::class);
    }

    public function cercle()
    {
        return $this->belongsToMany(\App\Models\Social\Cercle::class, 'post_cercle', 'post_id', 'cercle_id');
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Social\Post\PostComment::class);
    }
}
