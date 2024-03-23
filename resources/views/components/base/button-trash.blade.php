<button wire:click="{{ $function }}" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-original-title="{{ $tooltip }}" data-kt-initialized="1" wire:loading.attr="disabled" wire:confirm="{{ $confirm }}">
    <span wire:loading.remove><i class="fa-solid fa-trash"></i> </span>
    <span class="d-none" wire:loading.class.remove="d-none"><i class="fa-solid fa-spinner fa-spin"></i></span>
</button>
