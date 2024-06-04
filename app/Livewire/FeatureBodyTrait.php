<?php

namespace App\Livewire;

trait FeatureBodyTrait
{
    public function getBody()
    {
        ob_start();
        ?>
        <div class="d-flex flex-column align-items-center justify-content-center">
            <span class="fw-bold fs-1">Bientôt Disponible</span>
        </div>
        <?php
        return ob_get_clean();
    }
}
