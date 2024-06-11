<div class="d-flex flex-end justify-content-end align-items-center gap-3 mb-5">
    <a href="{{ route('train.buy') }}" class="btn btn-flush">
        <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['company.profil'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Informations">
            <img src="{{ Storage::url('icons/railway/technician.png') }}" alt="">
        </span>
    </a>
    <a href="" class="btn btn-flush">
        <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['train.index'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Classement">
            <img src="{{ Storage::url('icons/railway/ranking.png') }}" alt="">
        </span>
    </a>
    <a href="{{ route('train.index') }}" class="btn btn-flush">
        <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['train.index'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Compagnie">
            <img src="{{ Storage::url('icons/railway/hq.png') }}" alt="">
        </span>
    </a>
</div>
