@props(['title'])

<div class="d-flex justify-content-between align-items-center bg-gray-300 rounded-4 p-5 mb-10">
    <div class="d-flex align-items-center">
        <div class="symbol symbol-50px symbol-circle me-3">
            <div class="symbol-label bg-gray-100">
                <img src="{{ Storage::url('icons/railway/bank.png') }}" class="w-30px img-fluid" alt="">
            </div>
        </div>
        <span class="text-gray-800 fs-3 fw-semibold">{{ $title }}</span>
    </div>
    <div class="d-flex flex-end justify-content-end align-items-center gap-3 mb-5">
        <a href="{{ route('finance.bank.index') }}" class="btn btn-flush">
        <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['finance.bank.index'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Banque">
            <img src="{{ Storage::url('icons/railway/bank.png') }}" alt="">
        </span>
        </a>
        <a href="" class="btn btn-flush">
        <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['company.rank'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Comptabilité">
            <img src="{{ Storage::url('icons/railway/accounting.png') }}" alt="">
        </span>
        </a>
        <a href="" class="btn btn-flush">
        <span class="symbol symbol-40px symbol-circle bg-active-primary @if(route_is(['company.index'])) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Finance">
            <img src="{{ Storage::url('icons/railway/financial.png') }}" alt="">
        </span>
        </a>
    </div>
</div>
