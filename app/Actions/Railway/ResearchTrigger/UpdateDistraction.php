<?php

namespace App\Actions\Railway\ResearchTrigger;

use App\Models\Railway\Research\RailwayResearchTrigger;
use App\Models\User\ResearchUser;

class UpdateDistraction
{
    public function handle(RailwayResearchTrigger $trigger, int $current_level)
    {
        $lvl = $current_level + 1;
        match ($lvl) {
            1 => auth()->user()->railway_company->update(['distraction' => 2]),
            2 => auth()->user()->railway_company->update(['distraction' => 3]),
            3 => auth()->user()->railway_company->update(['distraction' => 4]),
            4 => auth()->user()->railway_company->update(['distraction' => 5]),
            5 => auth()->user()->railway_company->update(['distraction' => 6]),
        };

        ResearchUser::where('railway_research_id', $trigger->railway_researches_id)
            ->where('user_railway_id', auth()->user()->railway->id)
            ->first()
            ->update([
                'current_level' => $lvl,
            ]);
    }
}
