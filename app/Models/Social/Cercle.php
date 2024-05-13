<?php

namespace App\Models\Social;

use App\Models\Config\Service;
use App\Models\Social\Post\Post;
use App\Models\Wiki\WikiCategory;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Cercle extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $appends = [
        'cercle_icon',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_cercle', 'cercle_id', 'event_id');
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

    public function service()
    {
        return $this->hasOne(Service::class);
    }

    public function getImage(int $cercle_id, string $type)
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
        return Cache::remember('getCercleIconAttribute:'.$this->id, 1440, function () {
            return Storage::exists("cercles/$this->id/icon.png") ? Storage::url("cercles/$this->id/icon.png") : Storage::url('cercles/icon_default.png');
        });
    }
}
