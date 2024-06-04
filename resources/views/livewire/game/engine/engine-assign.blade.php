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
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Assignation à un hub</h3>
        </div>
        <div class="card-body">
            @foreach(auth()->user()->userRailwayHub()->where('id', '!=', $engine->userRailwayHub->id)->get() as $hub)
                <div class="d-flex flex-column bg-orange-100 p-5 mb-5 rounded-2">
                    <div class="d-flex flex-row justify-content-between align-items-center border border-bottom-2 border-top-0 border-left-0 border-right-0 pb-1 mb-5">
                        <div class="d-flex align-items-center">
                            <span class="badge bagde-circle badge-warning text-white me-2">Hub</span>
                            <span class="fw-bold fs-3">{{ $hub->railwayHub->gare->name }}</span>
                        </div>
                        <a href="{{ route('network.hub.show', $hub->id) }}" class="btn btn-flex bg-orange-600">
                        <span class="symbol symbol-35px me-2">
                            <img src="{{ Storage::url('icons/railway/hub.png') }}" alt="">
                        </span>
                            <span class="text-white">Détail du Hub</span>
                        </a>
                    </div>
                    <div class="d-flex flex-row align-items-center">
                        {!! $hub->getRatioPerformance() !!}
                        <div class="d-flex align-items-center me-5">
                            <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                            <span class="me-2">Chiffre d'affaires: </span>
                            <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getCA()) }}</span>
                        </div>
                        <div class="d-flex align-items-center me-5">
                            <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                            <span class="me-2">Bénéfices: </span>
                            <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getBenefice()) }}</span>
                        </div>
                        <button wire:click="assign({{ $hub->id }})" class="btn btn-warning">Assigner la rame</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
