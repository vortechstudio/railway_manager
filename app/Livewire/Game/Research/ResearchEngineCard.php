<?php

namespace App\Livewire\Game\Research;

use App\Models\User\Railway\UserRailwayEngine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ResearchEngineCard extends Component
{
    use LivewireAlert;
    public UserRailwayEngine $engine;

    public function optimizeSpace()
    {
        if($this->engine->user->railway->research_mat < 15) {
            $this->alert('question', "Voulez-vous lançer la recherche d'optimisation de l'espace", [
                'toast' => false,
                'position' => 'center',
                'timer' => null,
                'allowOutsideClick' => false,
                'showCancelButton' => true,
                'cancelButtonText' => 'Annuler',
                'cancelButtonColor' => '#ef5350',
                'html' => $this->getInfoOptimizeSpace(),
                'width' => '500px'
            ]);
        } else {
            $this->alert('question', "Voulez-vous lançer la recherche d'optimisation de l'espace", [
                'toast' => false,
                'position' => 'center',
                'timer' => null,
                'allowOutsideClick' => false,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Lancer la recherche',
                'onConfirmed' => 'confirmedOptimizeSpace',
                'showCancelButton' => true,
                'cancelButtonText' => 'Annuler',
                'cancelButtonColor' => '#ef5350',
                'html' => $this->getInfoOptimizeSpace(),
                'width' => '500px'
            ]);
        }

    }
    public function maxRuntimeIncrease()
    {
        if($this->engine->user->railway->research_mat < 30) {
            $this->alert('question', "Voulez-vous lançer la recherche d'augmentation de porté maximal ?", [
                'toast' => false,
                'position' => 'center',
                'timer' => null,
                'allowOutsideClick' => false,
                'showCancelButton' => true,
                'cancelButtonText' => 'Annuler',
                'cancelButtonColor' => '#ef5350',
                'html' => $this->getInfoMaxRuntimeIncrease(),
                'width' => '500px'
            ]);
        } else {
            $this->alert('question', "Voulez-vous lançer la recherche d'augmentation de porté maximal ?", [
                'toast' => false,
                'position' => 'center',
                'timer' => null,
                'allowOutsideClick' => false,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Lancer la recherche',
                'onConfirmed' => 'confirmedMaxRuntimeIncrease',
                'showCancelButton' => true,
                'cancelButtonText' => 'Annuler',
                'cancelButtonColor' => '#ef5350',
                'html' => $this->getInfoMaxRuntimeIncrease(),
                'width' => '500px'
            ]);
        }

    }

    #[On('confirmedOptimizeSpace')]
    public function confirmedOptimizeSpace()
    {
        $this->engine->user->railway->research_mat -= 15;
        $this->engine->user->railway->save();

        $this->engine->siege += intval($this->engine->siege * 5 / 100);
        $this->engine->save();
        $this->alert('success', "Mise à niveau effectuer.");
        $this->dispatch('refreshSoldeMat')->to(ResearchEngine::class);
    }

    #[On('confirmedMaxRuntimeIncrease')]
    public function confirmedMaxRuntimeIncrease()
    {
        $this->engine->user->railway->research_mat -= 30;
        $this->engine->user->railway->save();

        $this->engine->max_runtime += intval($this->engine->max_runtime * 3 / 100);
        $this->engine->save();
        $this->alert('success', "Mise à niveau effectuer.");
        $this->dispatch('refreshSoldeMat')->to(ResearchEngine::class);
    }

    public function render()
    {
        return view('livewire.game.research.research-engine-card');
    }

    private function getInfoOptimizeSpace()
    {
        ob_start();
        ?>
        <div class="d-flex flex-column">
            <p>Grâce à vos ingénieurs et vos techniciens vous êtes en mesure d'optimiser l'espace dans vos rames.</p>
            <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                <span>Coût de l'amélioration</span>
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-30px me-2">
                        <img src="<?= \Storage::url('icons/railway/maintenance.png') ?>" alt="">
                    </div>
                    <span class="fw-bold <?= $this->engine->user->railway->research_mat < 15 ? 'text-danger' : '' ?> fs-3">15</span>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                <span>Amélioration</span>
                <div class="d-flex align-items-center gap-5">
                    <span>Nombre de sièges: (+5%)</span>
                    <span class="text-success"><?= intval($this->engine->siege + ($this->engine->siege * 5 / 100)) ?></span>
                </div>
            </div>
            <?php if($this->engine->user->railway->research_mat < 15): ?>
                <p class="text-danger">Vos fonds de recherche sont insuffisants pour effectuer cette amélioration</p>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
    private function getInfoMaxRuntimeIncrease()
    {
        ob_start();
        ?>
        <div class="d-flex flex-column">
            <p>L'optimisation et l'amélioration des matériaux permettent l'augmentation des limites de trajet avant maintenance.</p>
            <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                <span>Coût de l'amélioration</span>
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-30px me-2">
                        <img src="<?= \Storage::url('icons/railway/maintenance.png') ?>" alt="">
                    </div>
                    <span class="fw-bold <?= $this->engine->user->railway->research_mat < 30 ? 'text-danger' : '' ?> fs-3">30</span>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                <span>Amélioration</span>
                <div class="d-flex align-items-center gap-5">
                    <span>Porté maximal: (+3%)</span>
                    <span class="text-success"><?= intval($this->engine->max_runtime + ($this->engine->max_runtime * 3 / 100)) ?> Km</span>
                </div>
            </div>
            <?php if($this->engine->user->railway->research_mat < 30): ?>
                <p class="text-danger">Vos fonds de recherche sont insuffisants pour effectuer cette amélioration</p>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
