<div class="mb-5">
    <span class="d-inline-block position-relative ms-2">
        <span class="d-inline-block mb-2 {{ $styleText ?? 'fs-2tx fw-bold' }}">
            {{ $title ?? 'Titre' }}
        </span>
        <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-{{ $color ?? 'primary' }} translate rounded"></span>
    </span>
</div>
