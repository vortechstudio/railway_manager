<?php

namespace App\View\Components\Base;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Underline extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = 'Titre',
        public string $color = 'primary',
        public string $styleText = 'fs-2tx fw-bold'
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.base.underline');
    }
}
