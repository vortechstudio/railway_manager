<div class="d-flex justify-content-between align-items-center gap-5 mb-3">
    <div>
        <i class="fa-solid fa-shopping-cart fs-3tx text-white me-2"></i>
        <span class="fw-bold fs-3tx text-white">Boutique</span>
    </div>
    <div class="d-flex gap-5">
        <div class="d-flex justify-content-between align-items-center w-250px rounded-1 bg-gray-100 bg-opacity-10 p-2 animate__animated animate__fadeIn">
            <div class="symbol symbol-50px">
                <img src="{{ Storage::url('icons/railway/argent.png') }}" alt="">
            </div>
            <span class="fw-bolder text-white fs-2x" data-kt-countup="true" data-kt-countup-value="{{ $argent }}" data-kt-countup-suffix="€">0</span>
        </div>
        <div class="d-flex justify-content-between align-items-center w-250px rounded-1 bg-gray-100 bg-opacity-10 p-2 animate__animated animate__fadeIn">
            <div class="symbol symbol-50px">
                <img src="{{ Storage::url('icons/railway/tpoint.png') }}" alt="">
            </div>
            <span class="fw-bolder text-white fs-2x" data-kt-countup="true" data-kt-countup-value="{{ $tpoint }}">0</span>
        </div>
    </div>
</div>
