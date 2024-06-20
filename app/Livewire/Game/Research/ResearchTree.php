<?php

namespace App\Livewire\Game\Research;

use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\CheckoutAction;
use App\Jobs\ResearchJob;
use App\Models\Railway\Research\RailwayResearchCategory;
use App\Models\Railway\Research\RailwayResearches;
use App\Models\User\Railway\UserResearchDelivery;
use App\Models\User\ResearchUser;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ResearchTree extends Component
{
    use LivewireAlert;

    public function start(int $research_id)
    {
        $research = RailwayResearches::with('users', 'triggers')->find($research_id);
        $user_search = ResearchUser::where('user_railway_id', auth()->user()->railway->id)
            ->where('railway_research_id', $research_id)
            ->first();

        try {
            if ((new CheckoutAction())->checkoutResearch($research->cost)) {
                $delivery = UserResearchDelivery::create([
                    'start_at' => now(),
                    'end_at' => now()->addMinutes($research->time_base),
                    'designation' => $research->name.' - Niveau '.$user_search->current_level + 1,
                    'research_user_id' => $user_search->id,
                    'user_railway_id' => auth()->user()->railway->id,
                ]);

                dispatch(new ResearchJob($delivery, $research, $user_search));
                $this->alert('success', 'La recherche à été lançé');

            } else {
                $this->alert('error', "Vous n'avez pas les fonds nécessaires pour lançé cette recherche !", ['toast' => false]);
            }

        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu');
        }
    }

    public function render()
    {
        $categories = RailwayResearchCategory::with('railwayResearches.childrens')->get();

        foreach ($categories as $category) {
            foreach ($category->railwayResearches as $research) {
                $research->is_unlocked = $research->isUnlockedForUser(auth()->user()->railway->id);
                $research->current_level = $research->users()->withPivot(['current_level', 'is_unlocked'])->where('user_id', auth()->user()->id)->first()->pivot->current_level;
                foreach ($research->childrens as $children) {
                    $children->is_unlocked = $children->isUnlockedForUser(auth()->user()->railway->id);
                    $children->current_level = $children->users()->withPivot(['current_level', 'is_unlocked'])->where('user_id', auth()->user()->id)->first()->pivot->current_level;
                }
            }
        }

        return view('livewire.game.research.research-tree', [
            'categories' => $categories,
        ]);
    }
}
