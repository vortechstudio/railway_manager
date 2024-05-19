<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Social\Article;
use App\Models\Social\Event;
use App\Models\Social\Post\Post;
use App\Models\Social\Post\PostComment;
use App\Models\Support\Tickets\Ticket;
use App\Models\Support\Tickets\TicketMessage;
use App\Models\User\Railway\UserRailway;
use App\Models\User\Railway\UserRailwayAchievement;
use App\Models\User\Railway\UserRailwayBonus;
use App\Models\User\Railway\UserRailwayCompany;
use App\Models\User\Railway\UserRailwayMessage;
use App\Models\User\Railway\UserRailwayReward;
use App\Models\User\Railway\UserRailwaySocial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

class User extends Authenticatable
{
    use AuthenticationLoggable, HasApiTokens, HasFactory, HasPushSubscriptions, Notifiable;

    protected $connection = 'mysql';

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

    protected $appends = [
        'has_notification',
        'count_notifications',
    ];

    protected ?int $unreadNotificationsCount = null;

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

    public function railway()
    {
        return $this->hasOne(UserRailway::class);
    }

    public function railway_social()
    {
        return $this->hasOne(UserRailwaySocial::class);
    }

    public function railway_messages()
    {
        return $this->hasMany(UserRailwayMessage::class);
    }

    public function railway_company()
    {
        return $this->hasOne(UserRailwayCompany::class);
    }

    public function railway_bonus()
    {
        return $this->hasOne(UserRailwayBonus::class);
    }

    public function railway_achievements()
    {
        return $this->hasMany(UserRailwayAchievement::class);
    }

    public function railway_rewards()
    {
        return $this->hasMany(UserRailwayReward::class);
    }

    public function scopeNotifiable(Builder $query)
    {
        return $query->whereHas('profil', function ($query) {
            $query->where('notification', true);
        });
    }

    public function scopeVerified(Builder $query)
    {
        return $query->whereNotNull('email_verified_at');
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

    public function getHasNotificationAttribute(): bool
    {
        $this->unreadNotificationsCount = $this->unreadNotificationsCount ?? $this->unreadNotifications()->count();

        return $this->unreadNotificationsCount > 0;
    }

    public function getCountNotificationsAttribute(): int
    {
        $this->unreadNotificationsCount = $this->unreadNotificationsCount ?? $this->unreadNotifications()->count();

        return $this->unreadNotificationsCount;
    }
}
