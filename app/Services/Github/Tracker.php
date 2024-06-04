<?php

namespace App\Services\Github;

use App\Actions\ErrorDispatchHandle;
use App\Models\Support\Tickets\Ticket;
use App\Services\Github\Github;
use Github\Exception\MissingArgumentException;

class Tracker extends Github
{
    public function createIssueOfTicket(Ticket $ticket)
    {
        try {
            $this->client->issues()
                ->create($this->owner, $this->repo, [
                    'title' => $ticket->subject,
                    'body' => $this->issueTicketBodyFormat($ticket),
                    'labels' => [$ticket->category->name, 'version::' . \VersionBuildAction::getVersionInfo()]
                ]);
        } catch (MissingArgumentException $e) {
            (new ErrorDispatchHandle())->handle($e);
        }
    }

    private function issueTicketBodyFormat(Ticket $ticket)
    {
        ob_start();
        ?>
        ## Description
        <?= $ticket->messages()->first()->message; ?>
        <?php
        return ob_get_clean();
    }
}
