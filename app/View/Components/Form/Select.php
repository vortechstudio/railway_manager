<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public $options,
        public string $label = '',
        public string $selectType = 'simple',
        public string $placeholder = '',
        public bool $noLabel = false,
        public bool $required = false,
        public bool $isModel = false,
        public string $model = '',
        public $value = null,
        public string $hint = '',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.select');
    }
}
