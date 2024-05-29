<?php

namespace App\Actions;

use App\Models\Railway\Config\RailwaySetting;
use App\Models\Railway\Core\Message;
use App\Models\User\User;
use App\Services\RailwayService;
use Illuminate\Support\Facades\Hash;
use Str;
use Vortechstudio\Helpers\Facades\Helpers;

class NewUserAction
{
    public function insertNewsMessageAccount(): void
    {
        $service = (new RailwayService())->getRailwayService();
        foreach (Message::where('service_id', $service->id)->where('message_type', 'global')->get() as $message) {
            $previous = $message->railway_messages()->where('message_id', $message->id)->first();
            $message->railway_messages()->create([
                'message_id' => $message->id,
                'user_id' => auth()->user()->id,
                'reward_type' => $previous->reward_type,
                'reward_value' => $previous->reward_value,
            ]);
        }
    }

    public function createUser(object $gUser, string $provider, ?object $service)
    {
        $user = User::query()->create([
            'name' => $gUser->name ?? $gUser->nickname,
            'email' => $gUser->email ?? Helpers::reference(10).'@vst.local',
            'password' => Hash::make('password0000'),
            'email_verified_at' => now(),
            'admin' => false,
            'uuid' => Str::uuid(),
        ]);

        $this->createLog($user, 'Création du compte utilisateur');
        $this->addUserSocial($user, $gUser, $provider);
        $this->addUserService($user, $service);
        $this->addUserProfil($user);
        $this->addUserRailway($user, $service);

        return $user;
    }

    public function createLog(\Illuminate\Database\Eloquent\Model|\LaravelIdea\Helper\App\Models\User\_IH_User_QB|\Illuminate\Database\Eloquent\Builder|User $user, string $string)
    {
        $user->logs()->create([
            'action' => $string,
            'user_id' => $user->id,
        ]);
    }

    public function addUserSocial(\Illuminate\Database\Eloquent\Model|\LaravelIdea\Helper\App\Models\User\_IH_User_QB|\Illuminate\Database\Eloquent\Builder|User $user, object $gUser, string $provider)
    {
        if (! $user->socials()->where('provider', $provider)->exists()) {
            $user->socials()->create([
                'provider' => $provider,
                'provider_id' => $gUser->id,
                'avatar' => $gUser->avatar,
                'user_id' => $user->id,
            ]);
        }
    }

    public function addUserService(\Illuminate\Database\Eloquent\Model|\LaravelIdea\Helper\App\Models\User\_IH_User_QB|\Illuminate\Database\Eloquent\Builder|User $user, ?object $service)
    {
        if(!$user->services()->where('service_id', 1)->exists()) {
            $user->services()->create([
                'status' => true,
                'premium' => false,
                'user_id' => $user->id,
                'service_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->createLog($user, "Inscription au service: Accès de base");
        }

        $user->services()->create([
            'status' => true,
            'premium' => false,
            'user_id' => $user->id,
            'service_id' => $service->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->createLog($user, "Inscription au service: {$service->name}");
    }

    public function addUserProfil(\Illuminate\Database\Eloquent\Model|\LaravelIdea\Helper\App\Models\User\_IH_User_QB|\Illuminate\Database\Eloquent\Builder|User $user)
    {
        $user->profil()->firstOrCreate(['user_id' => $user->id]);
    }

    public function addUserRailway(\Illuminate\Database\Eloquent\Model|\LaravelIdea\Helper\App\Models\User\_IH_User_QB|\Illuminate\Database\Eloquent\Builder|User $user, ?object $service)
    {
        if(!$user->services()->where('service_id', $service->id)->exists()) {
            $user->railway()->create([
                'user_id' => $user->id,
                'argent' => 0,
                'tpoint' => RailwaySetting::where('name', 'start_tpoint')->first()->value,
                'research' => RailwaySetting::where('name', 'start_research')->first()->value,
                'uuid' => rand(10000000, 99999999),
            ]);
        }
    }
}
