<?php

namespace App\Actions;

use App\Services\Github\Issues;

/**
 * Class ErrorDispatchHandle
 *
 * This class is responsible for handling errors and exceptions thrown in the application.
 */
class ErrorDispatchHandle
{
    public function handle(\Throwable $e): void
    {
        if(config('app.env') == 'staging' || config('app.env') == 'production') {
            $issue = new Issues(Issues::createIssueMonolog('exception', $e->getMessage(), [$e]));
            $issue->createIssueFromException();
        }
        \Log::emergency($e->getMessage(), [$e]);
    }
}
