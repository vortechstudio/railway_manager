<?php

namespace App\Livewire\Account;

use App\Actions\Compta;
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
        $message = auth()->user()->railway_messages()->find($message_id);

        try {
            foreach ($message->message->rewards as $reward) {
                match ($reward->reward_type->value) {
                    'argent' => (new Compta())->create(
                        auth()->user(),
                        'Bonus: '.$reward->reward_value,
                        $reward->reward_value,
                        'revenue',
                        'divers',
                        false,
                    ),
                    'tpoint' => auth()->user()->railway->update(['tpoint' => auth()->user()->railway->tpoint + $reward->reward_value]),
                };
                $this->dispatch('showModalReward', [
                    'id' => 'modalReward',
                    'reward_type' => $reward->reward_type,
                    'reward_value' => number_format($reward->reward_value, 0, ',', ' '),
                ]);
            }

            $message->reward_collected = true;
            $message->save();
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
