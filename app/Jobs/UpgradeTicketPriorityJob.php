<?php

namespace App\Jobs;

use App\Models\Support\Tickets\Ticket;
use App\Models\User\User;
use App\Notifications\SendMessageAdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpgradeTicketPriorityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Ticket $ticket)
    {
    }

    public function handle(): void
    {
        $user = auth()->user();
        $ollama = \Ollama::agent('Tu est un développeur français spécialiser dans le développement web. Ta mission ici est de définir la priorité des tickets de support ouvert par le client. Il existe trois niveau: low,medium et High. A toi de définir le status le plus significatif en fonction du sujet et du message envoyer. Tu doit uniquement retourner la désignation de la priorité à savoir: low,medium ou high');
        $result = $ollama->prompt("Sujet: {$this->ticket->subject} / Message: {$this->ticket->messages()->first()->message}")
            ->model('llama3')
            ->options(['temperature' => 0.8])
            ->stream(false)
            ->ask();
        $this->ticket->priority = \Str::lower($result['response']);
        $this->ticket->save();
        \Log::notice('Ollama à répondu:', [$result['response']]);
        User::where('admin', true)->get()->each(function (User $user) {
            $user->notify(new SendMessageAdminNotification(
                'Nouveau ticket de support ouvert',
                'alert',
                'warning',
                "Un nouveau ticket de support de type: {$this->ticket->category->name} à été ouvert par {$user->name}",
            ));
        });
        $this->ticket->user->notify(new SendMessageAdminNotification(
            'Ticket de support transmis',
            'alert',
            'success',
            "Votre ticket à bien été transmis à nos services sa priorité à été évaluer à {$this->ticket->priority_human}"
        ));
    }
}
