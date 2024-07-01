<div>
    <div class="card shadow-sm mb-5">
        <div class="card-header">
            <h3 class="card-title">{{ $engine->railwayEngine->name }} | {{ $engine->number }} | <span class="badge bg-amber-600 text-white me-2">Hub</span> {{ $engine->userRailwayHub->railwayHub->gare->name }} - {{ $engine->userRailwayHub->railwayHub->gare->pays }}</h3>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-sm-12 col-lg-6 mb-5 justify-content-center mx-auto">
                    <img src="{{ $engine->railwayEngine->getFirstImage($engine->railwayEngine->id) }}" alt="">
                </div>
                <div class="col-sm-12 col-lg-6 mb-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Vitesse Max:</span>
                        <span class="fw-bold">{{ $engine->railwayEngine->technical->velocity }} Km/h</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Type de train:</span>
                        <span class="fw-bold">{{ Str::ucfirst($engine->railwayEngine->type_train->value) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Type d'energie:</span>
                        <span class="fw-bold">{{ Str::ucfirst($engine->railwayEngine->type_energy->value) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Service de transport:</span>
                        <span class="fw-bold">{{ Str::ucfirst($engine->railwayEngine->type_transport->name) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Etat du matériel:</span>
                        <span class="fw-bold">{!! $engine->status_badge !!}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-5">
        <div class="card-header">
            <h3 class="card-title">Sièges</h3>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-sm-12 col-lg-9 mb-5">
                    <div class="d-flex flex-wrap border border-3 rounded-4 p-5 gap-5">
                        @if($engine->railwayEngine->type_transport->value == 'ter' || $engine->railwayEngine->type_transport->value == 'other')
                            @for($p = 0; $p <= $engine->siege; $p++)
                                <span class="bullet bg-color-ter h-10px w-10px"></span>
                            @endfor
                        @else
                            @for($p = 0; $p <= (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engine->railwayEngine))->getComposition('first'); $p++)
                                <span class="bullet bg-color-tgv h-10px w-10px"></span>
                            @endfor
                            @for($p = 0; $p <= (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engine->railwayEngine))->getComposition('second'); $p++)
                                <span class="bullet bg-color-ter h-10px w-10px"></span>
                            @endfor
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3 mb-5">
                    <div class="d-flex flex-column border border-3 rounded-4 p-5">
                        @if($engine->railwayEngine->type_transport->value == 'ter' || $engine->railwayEngine->type_transport->value == 'other')
                            <div class="d-flex align-items-center">
                                <span class="bullet bullet-dot bg-color-ter h-15px w-15px me-2" data-bs-toggle="tooltip" data-bs-title="Unique"></span>
                                <span>{{ (new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getComposition('second') }} P</span>
                            </div>
                        @else
                            <div class="d-flex align-items-center mb-2">
                                <span class="bullet bullet-dot bg-color-tgv h-15px w-15px me-2" data-bs-toggle="tooltip" data-bs-title="Première"></span>
                                <span>{{ (new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getComposition('first') }} P</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="bullet bullet-dot bg-color-ter h-15px w-15px me-2" data-bs-toggle="tooltip" data-bs-title="Seconde"></span>
                                <span>{{ (new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getComposition('second') }} P</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if($engine->railwayEngine->type_transport->value == 'tgv' || $engine->railwayEngine->type_transport->value == 'ic')

            @else
                <x-base.is-null text="La disposition des sièges pour ce type de Rame ne peut être modifier" />
            @endif
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Renommer la rame</h3>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">Numéro de l'appareil</span>
                <span>{{ $engine->number }}</span>
                <button wire:click="generateNumber" class="btn btn-sm btn-outline btn-outline-primary">Générer un numéro</button>
            </div>
        </div>
    </div>
</div>
