<?php

namespace App\Livewire\Account;

use App\Actions\Account\MailboxAction;
use App\Actions\Compta;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Mailboxes extends Component
{
    use LivewireAlert;
    public string $type;
    public $selectedMessage = null;

    public function read(int $message_id)
    {
        $this->selectedMessage = $message_id;
        try {
            auth()->user()->railway_messages()->find($message_id)->update(['is_read' => true]);
        }catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
        }
    }

    public function claim(int $message_id)
    {
        $message = auth()->user()->railway_messages()->find($message_id);

        try {
            match ($message->reward_type->value) {
                "argent" => (new Compta())->create(
                    auth()->user(),
                    'Bonus: '.$message->reward_value,
                    $message->reward_value,
                    'revenue',
                    'divers',
                    false,
                )
            };

            $message->reward_collected = true;
            $message->save();

            $this->dispatch('showModalReward', [
                'id' => 'modalReward',
                'reward_type' => $message->reward_type,
                'reward_value' => number_format($message->reward_value, 0, ',', ' '),
            ]);
        }catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors de l'attribution de la récompense");
        }
    }

    public function allDelete()
    {
        try {
            $messages = auth()->user()->railway_messages()
                ->get();

            foreach ($messages as $message) {
                $message->delete();
            }

            $this->alert('success', 'Tous les messages ont été supprimés');
        }catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors de la suppression des messages");
        }
    }

    public function render()
    {
        $messages = auth()->user()->railway_messages()->with('message')
            ->join(config('database.connections.mysql.database').'.messages', 'messages.id', '=', 'user_railway_messages.message_id')
            ->where('messages.message_type', $this->type)
            ->orderBy('created_at', 'desc')
            ->get();

        //dd($messages);
        return view('livewire.account.mailboxes', [
            'messages' => $messages
        ]);
    }
}
