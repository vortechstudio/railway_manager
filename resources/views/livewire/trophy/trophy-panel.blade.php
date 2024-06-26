<div>
    <div class="d-flex flex-row justify-content-between align-items-center border border-gray-300 border-bottom-2 border-right-0 border-left-0 border-top-0 mb-5">
        <span class="fs-2 fw-semibold text-light">{{ Str::ucfirst($sector) }}</span>
        <div class="fs-2 border border-gray-300 border-bottom-3 border-right-0 border-left-0 border-top-0">
            <span class="fs-1 text-yellow-700">{{ $countUserTotalSector }}</span>
            <span class="text-light">/{{ $countTotalSector }}</span>
        </div>
    </div>

    <div class="d-flex flex-column h-sm-100 h-lg-500px hover-scroll-y overflow-scroll">
        @foreach(\App\Models\Railway\Core\RailwayAchievement::with('rewards')->where('type', $sector)->get() as $k => $achievement)
            @php
                $claimed = $achievement->isUnlockedFor(auth()->user()) && \App\Models\User\Railway\UserRailwayAchievement::where('railway_achievement_id', $achievement->id)->first()->reward_claimed_at
            @endphp
            <div class="d-flex flex-row align-items-center @if(!$claimed) bg-gray-100 @else bg-gray-600 @endif bg-opacity-75 py-2 mb-5 hover-scale animate__animated animate__bounceInRight animate__delay-{{ $k }}">
                <span class="bullet bullet-vertical bg-primary w-3px h-100px me-5 ms-1 "></span>
                <div class="symbol symbol-90px me-2">
                    <img src="{{ Storage::url('icons/railway/success/'.$achievement->level->value.'.png') }}" alt="">
                </div>
                <div class="d-flex flex-column w-50 me-5">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <span class="text-light fs-2 fw-bold">{{ $achievement->name }}</span>
                    </div>
                    <span class="text-gray-500 fs-4 fst-italic">{{ $achievement->description}}
                </div>
                <div class="symbol symbol-90px shop-bg-or">
                    <img src="{{ Storage::url('icons/railway/'.$achievement->rewards()->first()->type->value.'.png') }}" alt="">
                    <span class="symbol-badge badge badge-secondary top-100 start-100">{{ number_format($achievement->rewards()->first()->quantity, 0, '.', ',') }}</span>
                </div>
                @if($achievement->isUnlockedFor(auth()->user()) && !$claimed)
                <div class="d-flex flex-row justify-content-end align-items-end w-30">
                    <button wire:click="claim({{ $achievement->id }})" class="btn btn-lg bg-yellow-600 border border-2 border-warning text-dark">Récupérer</button>
                </div>
                @endif
            </div>
        @endforeach

    </div>
</div>
