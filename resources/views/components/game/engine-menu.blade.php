<div class="d-flex flex-end justify-content-end align-items-center gap-3 mb-5">
    <a href="{{ route('train.buy') }}" class="btn btn-flush">
        <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['train.buy', 'train.checkout', 'train.rental'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Achat d'une rame">
            <img src="{{ Storage::url('icons/railway/train_buy.png') }}" alt="">
        </span>
    </a>
    <a href="" class="btn btn-flush">
        <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['train.index'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Technicentre">
            <img src="{{ Storage::url('icons/railway/maintenance.png') }}" alt="">
        </span>
    </a>
    <a href="{{ route('train.index') }}" class="btn btn-flush">
        <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['train.index'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gestion des rames">
            <img src="{{ Storage::url('icons/railway/train.png') }}" alt="">
        </span>
    </a>
</div>
