<?php

namespace App\Actions\Railway\ResearchTrigger;

class AccessFret
{
    public function handle()
    {
        auth()->user()->railway_company->update([
            'access_fret' => true,
        ]);
    }
}
