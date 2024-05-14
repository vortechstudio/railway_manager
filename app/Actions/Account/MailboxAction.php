<?php

namespace App\Actions\Account;

class MailboxAction
{
    public function addArgent(int $value)
    {
        auth()->user()->railway->argent += $value;
        auth()->user()->railway->save();
    }
}
