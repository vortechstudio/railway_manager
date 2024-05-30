<div>
    @if($user->userRailwayDelivery()->get()->count() > 0)
        <x-base.title title="Livraison en cours" />
        @foreach($user->userRailwayDelivery()->get() as $delivery)
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50 symbol-circle me-3">
                                    <img src="{{ $delivery->icon_type }}" alt="">
                                </div>
                                <span class="fw-bold">{{ $delivery->designation }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-clock text-warning fs-3 me-2"></i>
                                <span data-countdown-delivery="{{ $delivery->end_at->timestamp }}"></span>
                            </div>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-black bg-opacity-50 rounded mb-2">
                            <div class="bg-yellow-600 bg-striped rounded h-8px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-total-time="{{ $delivery->diff_in_second }}"></div>
                        </div>
                        <div class="d-flex flex-wrap mx-auto">
                            <button wire:click="accelerate({{ $delivery->id }})" class="btn btn-sm btn-primary w-100">Accélérer la livraison</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
