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
            <div class="card-title">
                <div class="symbol symbol-40px symbol-circle me-2">
                    <img src="{{ Storage::url('icons/railway/train.png') }}" alt="">
                </div>
                <span>Caractéristique de la rame</span>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-sm-12 col-lg-6 mb-5">
                    <div id="chartRadar" style="width: 100%; height: 250px;"></div>
                </div>
                <div class="col-sm-12 col-lg-6 mb-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Capacité:</span>
                        <span class="fw-bold">{{ $engine->siege }} P</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Consommation du la ligne actuel:</span>
                        <span class="fw-bold">{{ number_format((new \App\Services\Models\User\Railway\UserRailwayLigneAction($engine->userRailwayLigne))->consommationPuissance(), 2, ',', ' ') }} Kw</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="symbol symbol-40px symbol-circle me-2">
                    <img src="{{ Storage::url('icons/railway/train.png') }}" alt="">
                </div>
                <span>Informations Générales </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-lg-6 mb-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Date d'achat:</span>
                        <span class="fw-bold">{{ $engine->date_achat->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Prix d'achat:</span>
                        <span class="fw-bold">{{ Helpers::eur($engine->railwayEngine->price->achat) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Résultat Cumulés:</span>
                        <span class="fw-bold">{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getResultat()) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Rentabilité:</span>
                        <div class="h-8px mx-3 w-100 bg-light-primary  rounded" data-bs-toggle="tooltip" data-bs-title="{{ (new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getRentabilityPercent() }} %">
                            <div class="bg-danger rounded h-8px" role="progressbar" style="width: {{ (new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getRentabilityPercent() }}%;" aria-valuenow="{{ (new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getRentabilityPercent() }}" aria-valuemin="-100" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6 mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <span>Sièges:</span>
                        @if($engine->railwayEngine->type_transport->value == 'tgv' || $engine->railwayEngine->type_transport->value == 'ic')
                            <div class="h-8px mx-3 w-100 bg-light-primary rounded progress">
                                <div class="bg-color-tgv h-8px" role="progressbar" style="width: {{ ($engine->siege * 20 / 100) * 100 / $engine->siege }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-title="{{ (new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getComposition('second') }} P"></div>
                                <div class="bg-color-ter h-8px" role="progressbar" style="width: {{ ($engine->siege * 80 / 100) * 100 / $engine->siege }}%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-title="{{ (new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getComposition('first') }} P"></div>
                            </div>
                        @else
                            <div class="h-8px mx-3 w-100 bg-light-primary rounded" data-bs-toggle="tooltip" data-bs-title="{{ ($engine->siege) * 100 / $engine->siege }}%">
                                <div class="bg-color-ter rounded h-8px" role="progressbar" style="width: {{ ($engine->siege) * 100 / $engine->siege }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <div class="bgi-no-repeat d-flex flex-column p-5" style="background: url('{{ Storage::url("services/$service->id/game/incidents/resume.png") }}') no-repeat; width: 333px; height: 316px;">
                            <span class="fw-bold fs-3 text-center mb-5">Compte-rendu</span>
                            <div class="text-center fs-3 text-capitalize mb-5">
                                Usé à <span class="text-danger">{{ number_format((new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getTotalUsure(), 2) }} %</span>
                            </div>
                            <div class="d-flex justify-content-between fs-8 px-5">
                                <span>Nombre de trajets:</span>
                                <span class="fw-bold">{{ $engine->plannings()->where('status', 'arrival')->get()->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between px-5 fs-8">
                                <span>Heure de circulation:</span>
                                <span class="fw-bold">{{ now()->startOfDay()->addMinutes($engine->plannings()->where('status', 'arrival')->count() * $engine->userRailwayLigne->railwayLigne->time_min)->format('H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-between px-5 fs-8 mb-2">
                                <span>Age:</span>
                                <span class="fw-bold">{{ now()->diffInDays($engine->date_achat) }} jours</span>
                            </div>
                            <div class="text-center fs-4 mb-2">
                                <div>Note d'ancienneté</div>
                                <span>{{ $engine->indice_ancien }}/5</span>
                                <div class="text-muted fs-6">({{ number_format((new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getUsedRuntimeEngine(), 2) }} % d'usure / 100Km parcourue)</div>
                            </div>
                            <div class="d-flex justify-content-around align-items-center">
                                <div class="d-flex flex-column align-items-center">
                                    <button wire:click="welcoming" class="btn btn-sm btn-primary">Check A</button>
                                    <span>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getAmountMaintenancePrev()) }}</span>
                                </div>
                                <div wire:click="welcoming" class="d-flex flex-column align-items-center">
                                    <button class="btn btn-sm btn-primary">Check D</button>
                                    <span>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayEngineAction($engine))->getAmountMaintenanceCur()) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
    <script>
        let chartDom = document.querySelector("#chartRadar")
        let chart = echarts.init(chartDom)
        let options;

        options = {
            legend: {
                data: ['Répartition']
            },
            radar: {
                indicator: [
                    {name: 'Sièges', max: {{ \App\Models\User\Railway\UserRailwayEngine::max('siege') }}},
                    {name: 'Vitesse', max: {{ \App\Models\Railway\Engine\RailwayEngineTechnical::max('velocity') }}},
                    {name: 'Consommation', max: {{ \App\Models\Railway\Engine\RailwayEngineTechnical::max('puissance') }}},
                ]
            },
            series: [
                {
                    name: 'Spécificité Technique de la Rame',
                    type: 'radar',
                    data: [
                        {
                            value: [{{ $engine->siege }},{{ $engine->railwayEngine->technical->velocity }},{{ $engine->railwayEngine->technical->puissance }}],
                            name: 'Complétion de la rame'
                        }
                    ]
                }
            ]
        };

        options && chart.setOption(options);
    </script>
@endpush
