<?php

namespace App\View\Components\Base;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $isLink,
        public bool $isIcon,
        public string $link = '',
        public string $color = 'primary',
        public ?string $tooltip = null,
        public string $icon = 'fa-plus',
        public ?string $text = null,
        public ?string $action = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.base.button');
    }
}
