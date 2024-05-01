<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use App\Services\RailwayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Log;
use Str;
use Vortechstudio\Helpers\Facades\Helpers;
use Vortechstudio\Helpers\Helpers\Generator;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        return match ($provider) {
            'google' => $this->verifyUser($user, 'google'),
            'facebook' => $this->verifyUser($user, 'facebook'),
            'steam' => $this->verifyUser($user, 'steam'),
            'battlenet' => $this->verifyUser($user, 'battlenet'),
            'discord' => $this->verifyUser($user, 'discord'),
            'twitch' => $this->verifyUser($user, 'twitch'),
        };
    }

    private function verifyUser($user, string $provider)
    {
        $gUser = $user;
        $user = User::query()->where('email', $gUser->email)->first();
        $service = (new RailwayService())->getRailwayService();
        if (! $user) {
            $user = User::query()->create([
                'name' => $gUser->name ?? $gUser->nickname,
                'email' => $gUser->email ?? Helpers::reference(10).'@vst.local',
                'password' => Hash::make('password0000'),
                'email_verified_at' => now(),
                'admin' => false,
                'uuid' => Str::uuid(),
            ]);

            $user->logs()->create([
                'action' => "Création du compte utilisateur",
                'user_id' => $user->id
            ]);

            if (! $user->socials()->where('provider', $provider)->exists()) {
                $user->socials()->create([
                    'provider' => $provider,
                    'provider_id' => $gUser->id,
                    'avatar' => $gUser->avatar,
                    'user_id' => $user->id,
                ]);
            }

            $user->profil()->firstOrCreate(['user_id' => $user->id]);

            if(!$user->services()->where('service_id', $service->id)->exists()){
                $user->services()->create([
                    'status' => true,
                    'premium' => false,
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $user->logs()->create([
                    'action' => "Inscription au service: $service->name",
                    'user_id' => $user->id,
                ]);
            }

            return redirect()->route('auth.setup-account', [$provider, $user->email]);
        }

        if(!$user->services()->where('service_id', $service->id)->exists()){
            $user->services()->create([
                'status' => true,
                'premium' => false,
                'user_id' => $user->id,
                'service_id' => $service->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $user->logs()->create([
                'action' => "Inscription au service: $service->name",
                'user_id' => $user->id,
            ]);
        }

        Auth::login($user);
        $user->logs()->create([
            'action' => "Connexion au service: $service->name",
            'user_id' => $user->id,
        ]);

        return redirect()->route('home');
    }

    public function setupAccount(string $provider, string $email)
    {
        return view('auth.setupView', compact('provider', 'email'));
    }

    public function setupAccountSubmit(Request $request, string $provider, string $email)
    {
        $request->validate([
            'password' => 'required|min:8',
        ]);

        try {
            $user = User::where('email', $email)->firstOrFail();

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
        } catch (Exception $exception) {
            Log::emergency($exception->getMessage(), [$exception]);
        }

        return redirect()->route('home');
    }

    public function confirmPasswordForm()
    {
        return view('auth.password');
    }

    public function confirmPassword(Request $request)
    {
        if (! \Hash::check($request->password, $request->user()->password)) {
            toastr()
                ->addError('Mot de passe erronée', "Vérification d'accès !");
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended();
    }

    public function logout()
    {
        $service = (new RailwayService())->getRailwayService();
        $user = User::find(Auth::user()->id);
        $user->logs()->create([
            'action' => "Inscription au service: $service->name",
            'user_id' => $user->id,
        ]);
        \Auth::logout();
        \Session::flush();

        return redirect()->route('home');
    }
}
