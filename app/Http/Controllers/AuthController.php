<?php

namespace App\Http\Controllers;

use App\Actions\NewUserAction;
use App\Models\User\User;
use App\Services\RailwayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
     * @param  string  $provider  The social media provider (e.g. google, facebook, steam, etc.)
     * @return \Illuminate\Http\RedirectResponse The redirect response to the authentication page
     */
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Callback method that handles the authentication callback from different social media providers.
     *
     * @param  string  $provider  The social media provider (e.g. google, facebook, steam, etc.)
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
     * @param  object  $user  The user object returned by the social media provider
     * @param  string  $provider  The social media provider (e.g. google, facebook, steam, etc.)
     * @return \Illuminate\Http\RedirectResponse The response to redirect the user
     */
    private function verifyUser(object $user, string $provider)
    {
        $gUser = $user;
        $user = User::query()->where('name', $gUser->name)->first();
        $service = (new RailwayService())->getRailwayService();

        if (! $user) {
            $user = (new NewUserAction())->createUser($gUser, $provider, $service);

            return redirect()->route('auth.setup-account', [$provider, $user->email]);
        }

        if (! $user->services()->where('service_id', $service->id)->exists()) {
            (new NewUserAction())->addUserService($user, $service);
        } else {
            if (! $user->railway || ! $user->railway->installed) {
                Auth::login($user);

                return redirect()->route('auth.install');
            }
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

    public function confirmPasswordForm()
    {
        return view('auth.password');
    }

    /**
     * Confirm the user's password before granting access.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object
     * @return \Illuminate\Http\RedirectResponse The redirect response to the intended page
     */
    public function confirmPassword(Request $request)
    {
        if (! \Hash::check($request->password, $request->user()->password)) {
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
}
