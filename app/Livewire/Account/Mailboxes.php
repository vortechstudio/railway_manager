<?php

namespace App\Livewire\Account;

use App\Actions\Compta;
use App\Models\User\User;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Mailboxes extends Component
{
    use LivewireAlert;

    public string $type;

    public $selectedMessage = null;

    public function read(int $message_id): void
    {
        $this->selectedMessage = $message_id;
        try {
            auth()->user()->railway_messages()->find($message_id)->update(['is_read' => true]);
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
        }
    }

    public function claim(int $message_id): void
    {

        try {
            $user = User::find(auth()->id());
            $message = $user->railway_messages()->find($message_id);
            if($message->reward_collected) {
                $this->alert('error', "Vous avez déjà récupérer cette récompense !", [
                    'toast' => false,
                    'position' => 'center'
                ]);
            } else {
                $rewards = collect();
                foreach ($message->message->rewards as $reward) {
                    match ($reward->reward_type->value) {
                        'argent' => (new Compta())->create(
                            $user,
                            'Bonus: '.$reward->reward_value,
                            $reward->reward_value,
                            'revenue',
                            'divers',
                            false,
                        ),
                        'tpoint' => $user->railway->update(['tpoint' => $user->railway->tpoint + $reward->reward_value]),
                    };

                    $rewards->push([
                        'type' => $reward->reward_type->value,
                        'value' => $reward->reward_value,
                    ]);
                }

                $message->update([
                    'reward_collected' => true,
                ]);

                $this->dispatch('refreshToolbar');
                $this->alert('success', 'Récompense récupérée', [
                    'html' => $this->blockReward($rewards),
                    'toast' => false,
                    'allowOutsideClick' => true,
                    'timer' => null,
                    'position' => 'center',
                ]);
            }

        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors de l'attribution de la récompense");
        }

    }

    public function allDelete(): void
    {
        try {
            $messages = auth()->user()->railway_messages()
                ->get();

            foreach ($messages as $message) {
                $message->delete();
            }

            $this->alert('success', 'Tous les messages ont été supprimés');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', 'Erreur lors de la suppression des messages');
        }
    }

    public function blockReward(Collection $rewards)
    {
        $html = "<div class='d-flex flex-wrap justify-content-center align-items-center w-100 mx-auto gap-5 my-5'>";

        foreach ($rewards as $reward) {
            $html .= "<div class='d-flex flex-wrap justify-content-center align-items-center'>";
            $html .= "<div class='symbol symbol-150px border border-primary p-5 mb-2 animate__animated animate__flipInX animate__delay-1s'>";
            $html .= "<img class='' src='".\Storage::url("icons/railway/{$reward['type']}.png")."' alt=''>";
            $html .= '</div>';
            $html .= "<span class='badge badge-lg badge-light animate__animated animate__fadeInDown animate__delay-1s'>".htmlspecialchars($reward['value']).'</span>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    public function render()
    {
        $messages = auth()->user()->railway_messages()->with('message')
            ->join(config('database.connections.mysql.database').'.messages', 'messages.id', '=', 'user_railway_messages.message_id')
            ->where('messages.message_type', $this->type)
            ->orderBy('created_at', 'desc')
            ->select('user_railway_messages.*')
            ->get();

        //dd($messages);
        return view('livewire.account.mailboxes', [
            'messages' => $messages,
        ]);
    }
}
