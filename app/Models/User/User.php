<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Social\Article;
use App\Models\Social\Event;
use App\Models\Social\Post\Post;
use App\Models\Social\Post\PostComment;
use App\Models\Support\Tickets\Ticket;
use App\Models\Support\Tickets\TicketMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'email_verified_at',
        'otp',
        'otp_token',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function logs()
    {
        return $this->hasMany(UserLog::class);
    }

    public function profil()
    {
        return $this->hasOne(UserProfil::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'user_event', 'user_id', 'event_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function services()
    {
        return $this->hasMany(UserService::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);

    }

    public function socials()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function createAccessToken($name, $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = \Str::random(40)),
            'abilities' => $abilities,
            'last_used_at' => now(),
            'expires_at' => now()->addHour(),
        ]);

        return new NewAccessToken($token, $token->id.'|'.$plainTextToken);
    }
}
