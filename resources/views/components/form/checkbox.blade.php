<div class="mb-5">
    <div class="form-check form-check-custom {{ $checkboxSize ? 'form-check-' . $checkboxSize : '' }} {{ $checkboxColor ? 'form-check-' . $checkboxColor : '' }}">
        <input class="form-check-input" type="checkbox" {{ $checked ? 'checked' : '' }} value="{{ $value }}" id="{{ $name }}" wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}" {{ $required ? 'required' : '' }}/>
        <label class="form-check-label {{ !$required ?? 'required' }}" for="{{ $name }}">
            {{ $label }}
        </label>
    </div>
</div>
