<?php

namespace App\Http\Controllers;

use App\Models\Railway\Config\RailwaySetting;
use App\Models\User\User;
use App\Services\RailwayService;
use Exception;
use Faker\Factory;
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
    /**
     * Display the login form to the user.
     *
     * @return \Illuminate\Contracts\View\View The login view
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Redirects the user to the authentication page of the specified social media provider.
     *
     * @param string $provider The social media provider (e.g. google, facebook, steam, etc.)
     *
     * @return \Illuminate\Http\RedirectResponse The redirect response to the authentication page
     */
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Callback method that handles the authentication callback from different social media providers.
     *
     * @param string $provider The social media provider (e.g. google, facebook, steam, etc.)
     *
     * @return mixed The result of the verification process for the user
     *
     * @throws \Exception If the specified provider is not supported
     */
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
            default => throw new \Exception("Unsupported provider: {$provider}"),
        };
    }

    /**
     * Verify the user and handle the necessary actions based on the authentication process.
     *
     * @param object $user The user object returned by the social media provider
     * @param string $provider The social media provider (e.g. google, facebook, steam, etc.)
     *
     * @return \Illuminate\Http\RedirectResponse The response to redirect the user
     */
    private function verifyUser(object $user, string $provider)
    {
        $gUser = $user;
        $user = User::query()->where('email', $gUser->email)->first();
        $service = (new RailwayService())->getRailwayService();
        if (!$user) {
            $user = User::query()->create([
                'name' => $gUser->name ?? $gUser->nickname,
                'email' => $gUser->email ?? Helpers::reference(10) . '@vst.local',
                'password' => Hash::make('password0000'),
                'email_verified_at' => now(),
                'admin' => false,
                'uuid' => Str::uuid(),
            ]);

            $user->logs()->create([
                'action' => "Création du compte utilisateur",
                'user_id' => $user->id
            ]);

            if (!$user->socials()->where('provider', $provider)->exists()) {
                $user->socials()->create([
                    'provider' => $provider,
                    'provider_id' => $gUser->id,
                    'avatar' => $gUser->avatar,
                    'user_id' => $user->id,
                ]);
            }

            $user->services()->create([
                'status' => true,
                'premium' => false,
                'user_id' => $user->id,
                'service_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $user->logs()->create(['user_id' => $user->id, 'action' => 'Affiliation au service: Accès de base']);

            $user->profil()->firstOrCreate(['user_id' => $user->id]);

            if (!$user->services()->where('service_id', $service->id)->exists()) {
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

                $user->railway()->create([
                    'user_id' => $user->id,
                    'argent' => RailwaySetting::where('name', 'start_argent')->first()->value,
                    'tpoint' => RailwaySetting::where('name', 'start_tpoint')->first()->value,
                    'research' => RailwaySetting::where('name', 'start_research')->first()->value
                ]);
            }

            return redirect()->route('auth.setup-account', [$provider, $user->email]);
        }

        if (!$user->services()->where('service_id', $service->id)->exists()) {
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

    /**
     * Submit method for setting up an account.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object
     * @param string $provider The social media provider
     * @param string $email The user's email address
     *
     * @return \Illuminate\Http\RedirectResponse Redirects user to the home route
     */
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

            $user->railway()->update([
                'installed' => true,
                'name_secretary' => $request->get('name_secretary'),
                'name_company' => $request->get('name_company'),
                'desc_company' => $request->get('desc_company'),
                'name_conseiller' => fake('fr_FR')->name
            ]);

            $user->railway_social()->create([]);

            Auth::login($user);
            $service = (new RailwayService())->getRailwayService();
            $user->logs()->create([
                'action' => "Connexion au service: $service->name",
                'user_id' => $user->id,
            ]);
        } catch (Exception $exception) {
            Log::emergency($exception->getMessage(), [$exception]);
        }

        return redirect()->route('home');
    }

    public function confirmPasswordForm()
    {
        return view('auth.password');
    }

    /**
     * Confirm the user's password before granting access.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object
     *
     * @return \Illuminate\Http\RedirectResponse The redirect response to the intended page
     */
    public function confirmPassword(Request $request)
    {
        if (!\Hash::check($request->password, $request->user()->password)) {
            toastr()
                ->addError('Mot de passe erronée', "Vérification d'accès !");
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended();
    }

    /**
     * Logout method that handles the user logout process.
     *
     * @return \Illuminate\Http\RedirectResponse Redirects the user to the home page after logout
     */
    public function logout()
    {
        $service = (new RailwayService())->getRailwayService();
        $user = User::find(Auth::user()->id);
        $user->logs()->create([
            'action' => "Déconnexion du service: $service->name",
            'user_id' => $user->id,
        ]);
        \Auth::logout();
        \Session::flush();

        return redirect()->route('home');
    }

    public function install()
    {
        return view('auth.install');
    }

    public function installSubmit(Request $request)
    {
        try {
            $request->user()->railway()->create([
                'installed' => true,
                'name_secretary' => $request->get('name_secretary'),
                'name_company' => $request->get('name_company'),
                'desc_company' => $request->get('desc_company'),
                'name_conseiller' => fake('fr_FR')->name,
                'argent' => RailwaySetting::where('name', 'start_argent')->first()->value,
                'tpoint' => 0,
                'research' => 0,
                'automated_planning' => false,
                'user_id' => $request->user()->id
            ]);

            $request->user()->railway_social()->create([
                'user_id' => $request->user()->id
            ]);

            toastr()
                ->addSuccess('Votre compte a été configurer, Bienvenue');
            return redirect()->route('home');
        }catch (Exception $exception) {
            Log::emergency($exception->getMessage(), [$exception]);
            toastr()
                ->addError('Erreur lors de la création de votre compte, nous avons été alerter.');
            return redirect()->back();
        }
    }
}
