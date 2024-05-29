<div class="d-flex flex-end justify-content-end align-items-center gap-3 mb-5">
    <a href="" class="btn btn-flush">
                    <span class="symbol symbol-40px symbol-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Planifier">
                        <img src="{{ Storage::url('icons/railway/planning.png') }}" alt="">
                    </span>
    </a>
    <a href="{{ route('network.hub.buy') }}" class="btn btn-flush">
                    <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['network.hub.buy'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Acheter un hub">
                        <img src="{{ Storage::url('icons/railway/hub_checkout.png') }}" alt="">
                    </span>
    </a>
    <a href="{{ route('network.line.buy') }}" class="btn btn-flush">
                    <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['network.line.buy'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ouvrir une ligne">
                        <img src="{{ Storage::url('icons/railway/ligne_checkout.png') }}" alt="">
                    </span>
    </a>
    <a href="{{ route('network.index') }}" class="btn btn-flush">
                    <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['network.index'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Réseau ferroviaire">
                        <img src="{{ Storage::url('icons/railway/network.png') }}" alt="">
                    </span>
    </a>
</div>
