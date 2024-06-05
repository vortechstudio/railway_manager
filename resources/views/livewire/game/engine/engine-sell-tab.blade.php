<form action="" wire:submit="checkout">
    <div class="row">
        <div class="col-sm-12 col-lg-7 mb-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Information sur le matériel roulant</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-5">
                        <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3 w-45">
                            <span class="fw-bold">Date d'achat</span>
                            <span class="fs-1">{{ $this->engine->date_achat->format('d/m/Y') }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3 w-45">
                            <span class="fw-bold">Nombre de trajet</span>
                            <span class="fs-1">{{ $this->engine->plannings()->where('status', 'arrival')->count() }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3 w-45">
                            <span class="fw-bold">Km Parcourue</span>
                            <span class="fs-1">{{ $this->engine->plannings()->where('status', 'arrival')->sum('kilometer') }} km</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-light-{{ $this->engine->actual_usure_color }} rounded-3 w-45">
                            <span class="fw-bold">Usure Global</span>
                            <span class="fs-1">{{ round($this->engine->actual_usure, 2) }} %</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 @if($this->engine->resultat <= 0) bg-light-danger @else bg-light-success @endif rounded-3 w-45">
                            <span class="fw-bold">Résultat</span>
                            <span class="fs-1">{{ Helpers::eur($this->engine->resultat) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3 w-45">
                            <span class="fw-bold">Nombre d'incident</span>
                            <span class="fs-1">{{ $this->engine->incidents()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-5 mb-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="card-toolbar">
                        <button type="submit" class="btn btn-sm btn-success" wire:loading.attr="disabled">
                            <span wire:loading.remove>Vendre</span>
                            <span wire:loading><i class="fa-solid fa-spinner fa-spin me-2"></i> Vente en cours...</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column bg-gray-200 rounded-3 mb-3 p-5">
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Prix d'achat</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($engine->railwayEngine->price->achat) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Fluctuation du marché ({{ $engine->flux_market }} %)</span>
                            <span class="{{ $totalFlux <= 0 ? 'text-danger' : 'text-success' }}">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($totalFlux) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Prix actuel de revente</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($totalSelling) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
