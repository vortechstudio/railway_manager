<?php

namespace App\Actions\Railway\ResearchTrigger;

use App\Models\Railway\Research\RailwayResearchTrigger;
use App\Models\User\ResearchUser;

class ResearchConvRud
{
    public function handle(RailwayResearchTrigger $trigger, int $current_level)
    {
        $lvl = $current_level + 1;
        match ($lvl) {
            1 => auth()->user()->railway_company->update(['research_coast_max' => 35000]),
            2 => auth()->user()->railway_company->update(['research_coast_max' => 50000]),
            3 => auth()->user()->railway_company->update(['research_coast_max' => 75000]),
            4 => auth()->user()->railway_company->update(['research_coast_max' => 105000]),
            5 => auth()->user()->railway_company->update(['research_coast_max' => 145000]),
        };

        ResearchUser::where('railway_research_id', $trigger->railway_researches_id)
            ->where('user_railway_id', auth()->user()->railway->id)
            ->first()
            ->update([
                'current_level' => $lvl,
            ]);
    }
}
