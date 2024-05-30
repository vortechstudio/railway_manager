<div class="mb-10" @isset($control) wire:ignore @endisset>
    @if(!$noLabel)
    <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        wire:model.live="{{ $isModel ? $model.'.'.$name : $name }}"
        name="{{ $name }}"
        placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
        class="form-control {{ $class }} @error("$name") is-invalid @enderror"
        value="{{ $value }}"
        @isset($control) data-control="{{ $control }}" @endisset
        @if(isset($mask)) data-inputmask="{{ $mask }}" @endif>
    @error("$name")
        <span class="text-danger error">{{ $message }}</span>
    @enderror
    @if(isset($hint))
        <p>{{ $hint }}</p>
    @endif
</div>
