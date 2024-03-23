<div class="form-check form-switch form-check-custom {{ $classCheck ? 'form-check-'.$classCheck : '' }} form-check-solid" @if($alpine) x-on:change="{{ $funAlpine }}" @endif>
    <input class="form-check-input {{ $size ? 'w-'.$size[0].'px h-'.$size[1].'px' : '' }}" type="checkbox" wire:model="{{ $name }}" @if($checked) checked="checked" @endif value="{{ $value }}" id="{{ $name }}"/>
    <label class="form-check-label" for="{{ $name }}">
        {{ $label }}
    </label>
</div>
