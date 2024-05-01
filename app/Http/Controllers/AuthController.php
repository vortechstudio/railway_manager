<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
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
        };
    }

    private function verifyUser($user, string $provider)
    {

        $gUser = $user;
        $user = User::query()->where('email', $gUser->email)->first();
        if (! $user) {
            $user = User::query()->create([
                'name' => $gUser->name ?? $gUser->nickname,
                'email' => $gUser->email ?? Helpers::reference(10).'@vst.local',
                'password' => Hash::make('password0000'),
                'email_verified_at' => now(),
                'admin' => false,
                'uuid' => Str::uuid(),
            ]);

            if (! $user->socials()->where('provider', $provider)->exists()) {
                $user->socials()->create([
                    'provider' => $provider,
                    'provider_id' => $gUser->id,
                    'avatar' => $gUser->avatar,
                    'user_id' => $user->id,
                ]);
            }

            return redirect()->route('auth.setup-register', [$provider, $user->email]);
        }

        Auth::login($user);

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
        \Auth::logout();
        \Session::flush();

        return redirect()->route('home');
    }
}
