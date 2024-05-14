<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class MailboxController extends Controller
{
    public function __invoke()
    {
        return view('account.mailbox');
    }
}
