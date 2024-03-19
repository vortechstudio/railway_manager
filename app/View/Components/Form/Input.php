<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public ?string $label = '',
        public string $type = 'text',
        public string $placeholder = '',
        public bool $required = false,
        public string $value = '',
        public string $class = '',
        public bool $noLabel = false,
        public $mask = '',
        public bool $isModel = false,
        public string $model = '',
        public ?string $hint = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input');
    }
}
