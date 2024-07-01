<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title"><span class="badge badge-sm bg-primary me-2">{{ $engine->number }}</span>{{ $engine->railwayEngine->name }} / {{ $engine->userRailwayLigne->railwayLigne->name }}</h3>
    </div>
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center w-20">
                <img src="{{ $engine->railwayEngine->getFirstImage($engine->railway_engine_id) }}" class="w-150px img-fluid" alt="">
            </div>
            <div class="d-flex align-items-center w-80 gap-5">
                <div class="d-flex flex-column w-50">
                    <div class="d-flex justify-content-between rounded-2 bg-gray-100 p-5 mb-2 w-100">
                        <span>Utilisation</span>
                        <span>{{ $engine->use_percent }} %</span>
                    </div>
                    <div class="d-flex justify-content-between rounded-2 bg-gray-100 p-5 mb-2 w-100">
                        <span>Sièges</span>
                        <span>{{ $engine->siege }} P</span>
                    </div>
                    <div class="d-flex justify-content-between rounded-2 bg-gray-100 p-5 mb-2 w-100">
                        <span>Planification</span>
                        <span>{{ $engine->utilisation }} %</span>
                    </div>
                </div>
                <div class="d-flex flex-column w-50">
                    <div class="d-flex justify-content-between rounded-2 bg-gray-100 p-5 mb-2 w-100">
                        <span>Usure</span>
                        <span>{{ $engine->actual_usure }} %</span>
                    </div>
                    <div class="d-flex justify-content-between rounded-2 bg-gray-100 p-5 mb-2 w-100">
                        <span>Limite de parcoure</span>
                        <span>{{ $engine->max_runtime }} Km</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="accordion" id="accordion_research">
            <div class="accordion-item">
                <h2 class="accordion-header" id="kt_accordion_1_header_1">
                    <button class="accordion-button fs-4 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1" aria-expanded="false" aria-controls="kt_accordion_1_body_1">
                        Amélioration
                    </button>
                </h2>
                <div id="kt_accordion_1_body_1" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                    <div class="accordion-body">
                        <div class="d-flex justify-content-center align-items-center gap-5">
                            <button wire:click="optimizeSpace" class="btn btn-flex">
                                <span class="symbol symbol-100px" data-bs-toggle="tooltip" data-bs-title="Optimisation de l'espace">
                                    <span class="symbol-label bg-gray-200 bg-hover-light-primary">
                                        <img src="{{ Storage::url('icons/railway/first-class.png') }}" class="w-80 img-fluid" alt="">
                                    </span>
                                </span>
                            </button>
                            <button wire:click="maxRuntimeIncrease" class="btn btn-flex">
                                <span class="symbol symbol-100px" data-bs-toggle="tooltip" data-bs-title="Augmentation de la porté maximal">
                                    <span class="symbol-label bg-gray-200 bg-hover-light-primary">
                                        <img src="{{ Storage::url('icons/railway/ligne.png') }}" class="w-80 img-fluid" alt="">
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
