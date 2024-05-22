<div>
    @if(count($engines) == 0)
        <x-base.is-null
            text="Aucune rame disponible" />
    @else
        <div class="d-flex flex-column h-sm-100 h-lg-450px hover-scroll-y">
            @foreach($engines as $engine)
                <div class="d-flex flex-column bg-gray-200 p-5 mb-5 rounded-2">
                    <div class="d-flex flex-row justify-content-between align-items-center border border-gray-300 border-bottom-2 border-top-0 border-left-0 border-right-0 pb-1 mb-5">
                        <div class="d-flex align-items-center">
                            <span class="badge bagde-circle badge-primary text-white me-2">{{ $engine->number }}</span>
                            <span class="fw-bold fs-3 me-3">{{ $engine->railwayEngine->name }}</span>
                            {!! $engine->status_badge !!}
                        </div>
                        <button class="btn btn-flex bg-blue-600 bg-hover-primary">
                                <span class="symbol symbol-35px me-2">
                                    <img src="{{ Storage::url('icons/railway/train.png') }}" alt="">
                                </span>
                            <span class="text-white">Détail de la rame</span>
                        </button>
                    </div>
                    <div class="d-flex align-items-center p-5">
                        <img src="{{ $engine->railwayEngine->getFirstImage($engine->railway_engine_id) }}" class="img-fluid w-160px me-5" alt="">
                        <div class="d-flex flex-wrap w-50 gap-5 align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bullet bullet-dot"></div>
                                <span class="">Utilisation: </span>
                                <span class="fw-bold"> {{ $engine->use_percent }} %</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bullet bullet-dot"></div>
                                <span class="">Sièges: </span>
                                <span class="fw-bold"> {{ $engine->railwayEngine->technical->nb_marchandise }} P</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bullet bullet-dot"></div>
                                <span class="">Hub: </span>
                                <span class="fw-bold"> <span class="badge bg-orange-600 text-white me-2">Hub</span> {{ $engine->userRailwayHub->railwayHub->gare->name }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bullet bullet-dot"></div>
                                <span class="">Planification: </span>
                                <span class="fw-bold"> {{ $engine->utilisation }} %</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bullet bullet-dot"></div>
                                <span class="">Résultat: </span>
                                <span class="fw-bold"> {{ \Vortechstudio\Helpers\Facades\Helpers::eur($engine->resultat) }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bullet bullet-dot"></div>
                                <span class="">Usure: </span>
                                <span class="fw-bold"> {{ $engine->actual_usure }} %</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bullet bullet-dot"></div>
                                <span class="">Ancienneté: </span>
                                <span class="fw-bold"> {{ $engine->indice_ancien }} / 5</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
