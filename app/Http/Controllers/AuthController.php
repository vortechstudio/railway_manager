<?php

namespace App\Http\Controllers;

use App\Actions\Account\MailboxAction;
use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Actions\NewUserAction;
use App\Events\Model\User\Railway\NewUserEvent;
use App\Models\Railway\Config\RailwaySetting;
use App\Models\User\User;
use App\Services\RailwayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            if (! $user->railway->installed) {
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

    /**
     * Submit method for setting up an account.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request object
     * @param  string  $provider  The social media provider
     * @param  string  $email  The user's email address
     * @return \Illuminate\Http\RedirectResponse Redirects user to the home route
     */
    public function setupAccountSubmit(Request $request, string $provider, string $email)
    {
        $request->validate([
            'password' => 'required|min:8',
        ]);

        try {
            $user = User::where('email', $email)->firstOrFail();
            $this->updateUserPassword($user, $request->get('password'));
            $this->updateUserRailway($user, $request);
            $this->createUserSocialCompanyBonus($user);
            $this->loginAndSendWelcomeMessage($user, $provider);
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
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

    public function installSubmit(Request $request)
    {
        try {
            $this->updateUserRailway($request->user(), $request);
            $this->createUserSocialCompanyBonus($request->user());
            $this->loginAndSendWelcomeMessage($request->user());

            toastr()
                ->addSuccess('Votre compte a été configurer, Bienvenue');

            return redirect()->route('home');
        } catch (Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            toastr()
                ->addError('Erreur lors de la création de votre compte, nous avons été alerter.');

            return redirect()->back();
        }
    }

    private function updateUserPassword(User $user, mixed $password): void
    {
        $user->update(['password' => Hash::make($password)]);
    }

    private function updateUserRailway(User $user, Request $request): void
    {
        $user->railway()->updateOrCreate([
            'uuid' => rand(10000000, 99999999),
            'installed' => true,
            'name_secretary' => $request->get('name_secretary'),
            'name_company' => $request->get('name_secretary'),
            'desc_company' => $request->get('desc_company'),
            'name_conseiller' => fake('fr_FR')->name,
            'automated_planning' => false,
            'user_id' => $user->id,
            'argent' => 0,
            'tpoint' => 0,
            'research' => 0,
        ]);
    }

    private function createUserSocialCompanyBonus(User $user): void
    {
        $user->railway_social()->create(['user_id' => $user->id]);
        $user->railway_company()->create([
            'user_id' => $user->id,
            'distraction' => 1,
            'tarification' => 1,
            'ponctualite' => 1,
            'securite' => 1,
            'confort' => 1,
            'rent_aux' => 1,
            'frais' => 1,
            'livraison' => 1,
            'subvention' => 10,
        ]);
        $user->railway_bonus()->create(['user_id' => $user->id]);
    }

    private function loginAndSendWelcomeMessage(User $user): void
    {
        (new Compta())->create(
            $user,
            'Compte de départ',
            RailwaySetting::where('name', 'start_argent')->first()->value,
            'revenue',
            'divers',
            false,
        );

        Auth::login($user);
        $service = (new RailwayService())->getRailwayService();
        (new NewUserAction())->createLog($user, "Connexion au service {$service->name}");
        event(new NewUserEvent($user));
        (new MailboxAction())->newMessage(
            user: $user,
            subject: 'Bienvenue sur railway Manager',
            message: "<p>Cher joueur,</p>

<p>Nous sommes ravis de vous accueillir dans le monde passionnant de Railway Manager. Vous venez d'entrer dans une communauté de passionnés de trains et de simulations stratégiques.</p>

<p>Notre jeu vous offre l'opportunité de prendre les commandes de votre propre réseau ferroviaire. Construisez des voies, achetez des locomotives, gérez les horaires de trains, et plus encore. Vous découvrirez le frisson de conduire des trains, le défi de gérer un réseau ferroviaire en constante évolution, et le plaisir de la planification stratégique.</p>

<p>Pour commencer votre aventure, nous vous recommandons de suivre le tutoriel intégré qui vous guidera à travers les bases du jeu. Si vous avez des questions ou si vous avez besoin d'aide, n'hésitez pas à consulter notre forum de la communauté ou à contacter notre équipe de support.</p>

<p>Nous avons hâte de voir le réseau ferroviaire que vous allez construire. Nous espérons que vous apprécierez votre voyage dans le monde de Railway Manager.</p>

<p>Bon jeu et à bientôt sur les rails !</p>

<p>Votre équipe Railway Manager</p>",
            rewards: [
                [
                    'type' => 'argent',
                    'value' => 100000,
                ],
                [
                    'type' => 'tpoint',
                    'value' => 250,
                ],
            ]
        );
    }
}
