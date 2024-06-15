<div class="card shadow-sm mb-5">
    <div class="card-header bg-blue-600 text-white">
        <h3 class="card-title text-white">{{ $ligne->railwayLigne->name }}</h3>
        <div class="card-toolbar">
            @if($blocked)
                <div class="d-flex align-items-center text-danger">
                    <div class="symbol symbol-20px me-2">
                        <i class="fa-solid fa-exclamation-triangle text-danger"></i>
                    </div>
                    <span>{{ $alertLigne }}</span>
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
                        <span>Nombre de départ par jours</span>
                        <span class="fs-3 fw-bold">{{ $ligne->nb_depart_jour }} => <span class="text-success">{{ intval((new \App\Services\Models\User\Railway\UserRailwayLigneAction($ligne))->getLevelNextStatus('nb_depart_jour')) }}</span></span>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-center align-items-center">
                <div class="symbol symbol-200px symbol-circle">
                    <div class="symbol-label bg-primary text-white fs-5qx">{{ $ligne->level }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
