<button class="btn btn-{{ $classColor }} {{ !empty($size) ? 'btn-'.$size : '' }}" type="submit" wire:loading.attr="disabled">
    <span wire:loading.class="d-none">{{ $textSubmit }}</span>
    <span class="d-none" wire:loading.class.remove="d-none">
        {{ $textLoading }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
    </span>
</button>
