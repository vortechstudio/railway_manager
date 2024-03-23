@if($isLink)
    @if($isIcon)
        <a href="{{ $link }}" class="btn btn-sm btn-icon btn-outline btn-outline-{{ $color }}" @if(isset($tooltip)) data-bs-toggle="tooltip" data-bs-original-title="{{ $tooltip }}" @endif>
            <i class="fa-solid {{ $icon }}"></i>
        </a>
    @else
        <a href="{{ $link }}" class="btn btn-sm btn-outline btn-outline-{{ $color }}" @if(isset($tooltip)) data-bs-toggle="tooltip" data-bs-original-title="{{ $tooltip }}" @endif>
            <i class="fa-solid {{ $icon }}"></i> {{ $text }}
        </a>
    @endif
@else
    @if($isIcon)
        <button wire:click="{{ $action }}" class="btn btn-sm btn-icon btn-outline btn-outline-{{ $color }}" @if(isset($tooltip)) data-bs-toggle="tooltip" data-bs-original-title="{{ $tooltip }}" @endif>
            <i class="fa-solid {{ $icon }}"></i>
        </button>
    @else
        <button wire:click="{{ $action }}" class="btn btn-sm btn-outline btn-outline-{{ $color }}" @if(isset($tooltip)) data-bs-toggle="tooltip" data-bs-original-title="{{ $tooltip }}" @endif>
            <i class="fa-solid {{ $icon }}"></i> {{ $text }}
        </button>
    @endif
@endif
