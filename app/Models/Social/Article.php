<?php

namespace App\Models\Social;

use App\Enums\Social\ArticleTypeEnum;
use App\Models\User\User;
use App\Services\Github\Issues;
use Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Categorizable\Traits\Categorizable;
use Storage;

/**
 * @mixin IdeHelperArticle
 */
class Article extends Model
{
    use Categorizable, HasFactory;

    protected $guarded = [];

    protected $connection = 'mysql';

    protected $casts = [
        'published_at' => 'datetime',
        'publish_social_at' => 'datetime',
        'type' => ArticleTypeEnum::class,
        'status' => 'string',
    ];

    protected $appends = [
        'image_head',
        'image',
        'url',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function cercle()
    {
        return $this->belongsTo(Cercle::class);
    }

    public function getImageHeadAttribute()
    {
        return Cache::remember('getBlogImageHeadAttribute:'.$this->title, 1440, function () {
            return Storage::exists("blog/$this->id/header.webp") ? Storage::url("blog/$this->id/header.webp") : Storage::url('blog/header_default.png');
        });
    }

    public function getImageAttribute()
    {
        return Cache::remember('getBlogImageAttribute:'.$this->title, 1440, function () {
            return Storage::exists("blog/$this->id/default.webp") ? Storage::url("blog/$this->id/default.webp") : Storage::url('blog/default.png');
        });
    }

    public function getUrlAttribute()
    {
        return 'https://'.config('app.domain').'/news/'.$this->cercle_id.'/'.\Str::slug($this->title);
    }

    public static function publish(int $id)
    {
        $article = Article::find($id);
        try {
            $article->update([
                'published' => true,
                'publish_social' => true,
                'published_at' => now(),
                'publish_social_at' => now(),
                'status' => 'published',
            ]);

            return true;
        } catch (\Exception $Exception) {
            $issue = Issues::createIssueMonolog('article', "Impossible de publier l'article", [$Exception], 'emergency');
            (new Issues($issue))->createIssueFromException();

            return false;
        }
    }

    public static function unpublish(int $id)
    {
        $article = Article::find($id);

        try {
            $article->update([
                'published' => false,
                'publish_social' => false,
                'published_at' => null,
                'publish_social_at' => null,
                'status' => 'draft',
            ]);

            return true;
        } catch (\Exception $exception) {
            $issue = Issues::createIssueMonolog('article', "Impossible de dépublier l'article", [$exception], 'emergency');
            (new Issues($issue))->createIssueFromException();

            return false;
        }
    }
}
