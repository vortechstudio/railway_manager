<?php

namespace App\View\Components\Base;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IsNull extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $text = 'Aucunes données actuellement disponible'
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.base.is-null');
    }
}
