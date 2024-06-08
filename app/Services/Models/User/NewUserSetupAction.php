<?php

namespace App\Services\Models\User;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Events\Model\User\Railway\NewUserEvent;
use App\Models\Config\Service;
use App\Models\Railway\Config\RailwaySetting;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Actions\Account\MailboxAction;

class NewUserSetupAction
{
    public function __construct(private User $user)
    {
    }

    public function updateUserPassword(string $newPassword)
    {
        try {
            $this->user->update([
                'password' => \Hash::make($newPassword)
            ]);
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    public function updateUserRailway(array $data)
    {
        try {
            if($this->user->railway()->first()) {
                $this->user->railway()->update([
                    'uuid' => rand(10000000, 99999999),
                    'installed' => true,
                    'name_secretary' => $data['name_secretary'],
                    'name_company' => $data['name_company'],
                    'desc_company' => $data['desc_company'],
                    'name_conseiller' => fake('fr_FR')->name,
                    'automated_planning' => false,
                    'user_id' => $this->user->id,
                    'argent' => 0,
                    'tpoint' => 0,
                    'research' => 0,
                ]);
            } else {
                $this->user->railway()->create([
                    'uuid' => rand(10000000, 99999999),
                    'installed' => true,
                    'name_secretary' => $data['name_secretary'],
                    'name_company' => $data['name_company'],
                    'desc_company' => $data['desc_company'],
                    'name_conseiller' => fake('fr_FR')->name,
                    'automated_planning' => false,
                    'user_id' => $this->user->id,
                    'argent' => 0,
                    'tpoint' => 0,
                    'research' => 0,
                ]);
            }

        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    public function createUserSocialCompanyBonus()
    {
        try {
            $this->user->railway_social()->create(['user_id' => $this->user->id]);

            $this->user->railway_company()->create([
                'user_id' => $this->user->id,
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

            $this->user->railway_bonus()->create(['user_id' => $this->user->id]);
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    public function loginAndSendWelcomeMessage()
    {
        (new Compta())->create(
            user: $this->user,
            title: 'Apport de départ',
            amount: RailwaySetting::where('name', 'start_argent')->first()->value,
            type_amount: 'revenue',
            type_mvm: 'divers',
            valorisation: false
        );

        \Auth::login($this->user);
        $service = Service::where('name', 'like', '%Railway Manager%')->first();
        $this->createLog($this->user, "Connexion au service: {$service->name}");
        event(new NewUserEvent($this->user));
        (new MailboxAction())->newMessage(
            user: $this->user,
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

    public function createLog(\Illuminate\Database\Eloquent\Model|\LaravelIdea\Helper\App\Models\User\_IH_User_QB|\Illuminate\Database\Eloquent\Builder|User $user, string $string): void
    {
        $user->logs()->create([
            'action' => $string,
            'user_id' => $user->id,
        ]);
    }
}
