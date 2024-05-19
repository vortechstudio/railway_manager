<?php

namespace App\Livewire\Core;

use App\Actions\ErrorDispatchHandle;
use App\Jobs\UpgradeTicketPriorityJob;
use App\Services\RailwayService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserMenu extends Component
{
    use LivewireAlert, WithFileUploads;
    public $articles;

    //form Bug Tracker
    public int $ticket_category_id = 0;
    public string $subject = '';
    public string $message = '';

    public function mount()
    {
        $this->articles = (new RailwayService())->getRailwayArticles();
    }

    public function sendBug()
    {
        try {
            $ticket = auth()->user()->tickets()->create([
                'subject' => $this->subject,
                'status' => 'open',
                'priority' => 'low',
                'user_id' => auth()->id(),
                'service_id' => (new RailwayService())->getRailwayService()->id,
                'ticket_category_id' => $this->ticket_category_id,
            ]);

            $ticket->messages()->create([
                'message' => $this->message,
                'user_id' => auth()->id(),
                'ticket_id' => $ticket->id,
            ]);

            dispatch(new UpgradeTicketPriorityJob($ticket));
            $this->dispatch('closeDrawer', 'drawer_bug_tracker');
            $this->dispatch('closeDrawer', 'drawer_user_menu');
            $this->alert('success', 'Votre rapport à bien été pris en compte');
        }catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur est survenue !');;
        }
    }

    public function render()
    {
        return view('livewire.core.user-menu', [
            'articles' => json_encode($this->articles),
            'countMessage' => auth()->user()->railway_messages()->where('is_read', false)->get()->count(),
        ]);
    }
}
