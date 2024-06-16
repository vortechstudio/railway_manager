<?php

namespace App\Services\Models\Railway\Research;

use App\Models\Railway\Research\RailwayResearches;

class RailwayResearchAction
{
    public function __construct(private RailwayResearches $researches)
    {
    }

    public function getPopoverContent()
    {
        $triggers = $this->researches->triggers;
        $current_level = $this->researches->users()->withPivot(['current_level', 'is_unlocked'])->where('user_id', auth()->user()->id)->first()->pivot->current_level;
        $is_unlocked = $this->researches->users()->withPivot(['current_level', 'is_unlocked'])->where('user_id', auth()->user()->id)->first()->pivot->is_unlocked;
        $next_level = $current_level + 1;
        $next_label_level = $next_level >= $current_level ? $triggers->last()->name : ($current_level == 0 ? $triggers->first()->name : $triggers->where('action_count', $next_level)->first()->name);
        ob_start();
        ?>
        <div class="d-flex flex-column rounded-3 bg-color-ter text-white p-5 w-300px">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-50px me-3">
                    <img src="<?= $this->researches->image ?>" alt="">
                </div>
                <div class="d-flex flex-column">
                    <span><?= $this->researches->name ?></span>
                    <?php if ($is_unlocked) { ?>
                    <span class="text-blue-200"><?= $next_label_level ?></span>
                    <?php } else { ?>
                        <span class="text-red-200">Pré requis non rempli</span>
                    <?php } ?>
                </div>
            </div>
            <div class="separator my-5"></div>
            <div class="d-flex flex-wrap w-100 fs-7 fst-italic"><?= $this->researches->description ?></div>
            <div class="d-flex flex-column">
                <?php foreach ($triggers as $k => $trigger) { ?>
                    <div class="d-flex align-items-center py-2 <?= $k + 1 <= $current_level ? 'text-blue-300' : 'text-gray-200 opacity-25' ?>">
                        <span class="bullet <?= $k + 1 <= $current_level ? 'bg-green-500' : 'bg-gray-800' ?> me-5"></span> <?= $trigger->name ?>
                    </div>
                <?php } ?>
            </div>
            <?php if ($current_level <= $this->researches->level) { ?>
                <div class="separator my-5"></div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="<?= \Storage::url('icons/railway/argent.png') ?>" alt="" class="w-20px img-fluid me-3">
                        <span><?= \Helpers::eur($this->researches->cost) ?></span>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="<?= \Storage::url('icons/railway/research.png') ?>" alt="" class="w-20px img-fluid me-3">
                        <span><?= \Helpers::minToHours($this->researches->time_base) ?></span>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
