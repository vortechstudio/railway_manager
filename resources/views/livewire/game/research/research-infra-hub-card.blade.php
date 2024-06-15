<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">{{ $hub->railwayHub->gare->name }}</h3>
        <div class="card-toolbar">
            @if($blocked)
                <div class="d-flex align-items-center text-danger">
                    <div class="symbol symbol-20px me-2">
                        <i class="fa-solid fa-exclamation-triangle text-danger"></i>
                    </div>
                    <span>{{ $alertHub }}</span>
                </div>
            @else
                <button wire:click="claim" type="button" class="btn btn-sm btn-light">
                    Améliorer
                </button>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div class="row w-80">
                <div class="col-sm-12 col-lg-6 mb-10">
                    <div class="d-flex justify-content-between align-items-center rounded-3 bg-gray-200 p-5 mb-5">
                        <span>Limite de Ligne</span>
                        <span class="fs-3 fw-bold">{{ $hub->ligne_limit }} => <span class="text-success">{{ intval((new \App\Services\Models\User\Railway\UserRailwayHubAction($hub))->getNextLevelStatus('ligne_limit')) }}</span></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center rounded-3 bg-gray-200 p-5 mb-5">
                        <span>Nombre de commerce</span>
                        <span class="fs-3 fw-bold">{{ $hub->commerce_limit }} => <span class="text-success">{{ intval((new \App\Services\Models\User\Railway\UserRailwayHubAction($hub))->getNextLevelStatus('commerce')) }}</span></span>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6 mb-10">
                    <div class="d-flex justify-content-between align-items-center rounded-3 bg-gray-200 p-5 mb-5">
                        <span>Nombre d'emplacement publicitaire</span>
                        <span class="fs-3 fw-bold">{{ $hub->publicity_limit }} => <span class="text-success">{{ intval((new \App\Services\Models\User\Railway\UserRailwayHubAction($hub))->getNextLevelStatus('publicity')) }}</span></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center rounded-3 bg-gray-200 p-5 mb-5">
                        <span>Nombre de place de parking</span>
                        <span class="fs-3 fw-bold">{{ $hub->parking_limit }} => <span class="text-success">{{ intval((new \App\Services\Models\User\Railway\UserRailwayHubAction($hub))->getNextLevelStatus('parking')) }}</span></span>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-center align-items-center">
                <div class="symbol symbol-200px symbol-circle">
                    <div class="symbol-label bg-primary text-white fs-5qx">{{ $hub->level }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
