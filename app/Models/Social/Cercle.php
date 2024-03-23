<?php

namespace App\Models\Social;

use App\Models\Social\Post\Post;
use App\Models\Wiki\WikiCategory;
use Illuminate\Database\Eloquent\Model;

class Cercle extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $appends = [
        'cercle_icon',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function wiki_categories()
    {
        return $this->hasMany(WikiCategory::class);
    }

    public static function getImage(int $cercle_id, string $type)
    {
        $type = match ($type) {
            'icon' => 'icon',
            'header' => 'header',
            'default' => 'default',
        };

        if (\Storage::exists('cercles/'.$cercle_id.'/'.$type.'.webp')) {
            return \Storage::url('cercles/'.$cercle_id.'/'.$type.'.webp');
        } else {
            return \Storage::url('cercles/'.$type.'_default.png');
        }
    }

    public function getCercleIconAttribute()
    {
        if (\Storage::disk('public')->exists("cercles/{$this->id}/icon.png")) {
            return asset("/storage/cercles/{$this->id}/icon.png");
        } else {
            return asset('/storage/cercles/icon_default.png');
        }
    }
}
