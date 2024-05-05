<div class="mb-10">
    <label for="{{ $name }}" class="{{ !$required ?? 'required' }} form-label">{{ $label }}</label>
    <textarea
        name="{{ $name }}"
        class="form-control"
        @if($livewire)
            wire:model="{{ $isModel ? $model.'.'.$name : $name }}"
        @endif
        @if($type != 'simple')
            data-controls="{{ $type }}"
        @endif
        @if($required) required @endif>{{ $value }}</textarea>
</div>
