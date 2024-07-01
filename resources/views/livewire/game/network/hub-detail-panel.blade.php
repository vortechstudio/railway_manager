<div>
    <div class="row">
        <div class="col-sm-12 col-lg-3 mb-5">
            @php
                use Illuminate\Database\Eloquent\Builder;$planning = $hub->plannings()
                    ->whereBetween('date_depart', [now()->startOfDay(), now()->endOfDay()])
                    ->where(function (Builder $query) {
                        $query->where('status', 'initialized')
                        ->orWhere('status', 'departure')
                        ->orWhere('status', 'retarded')
                        ->orWhere('status', 'canceled');
                    })
                    ->orderBy('date_depart', 'desc')
                    ->first();
                \Carbon\Carbon::setLocale('fr');
            @endphp
            @if(isset($planning))
                <div
                    class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 bg-blue-200 mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Prochain départ</h3>
                        <div class="card-toolbar">
                            @if($planning->status->value == 'initialized')
                                <div class="d-flex align-items-center rounded-3 border border-1 border-primary p-1">
                                    <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                    <span class="fs-4 text-blue-800 fw-semibold"> à l'heure</span>
                                </div>
                            @elseif($planning->status->value == 'retarded')
                                <div
                                    class="d-flex align-items-center rounded-3 bg-orange-600 border border-orange-900 p-2">
                                    <div class="animate__animated animate__flash animate__infinite">
                                        <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                        <span class="fs-4 text-blue-800 fw-semibold"> Retardé</span>
                                    </div>
                                </div>
                            @elseif($planning->status->value == 'canceled')
                                <div class="d-flex align-items-center rounded-3 bg-red-600 border border-red-900 p-2">
                                    <div class="">
                                        <i class="fa-solid fa-clock-four text-white me-2 fs-3"></i>
                                        <span class="fs-4 text-white fw-semibold"> Annulé</span>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex align-items-center rounded-3 border border-primary p-1">
                                    <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                    <span class="fs-4 text-blue-800 fw-semibold"> Départ Imminent</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span
                                class="fw-bold fs-3">{{ $planning->userRailwayLigne->railwayLigne->start->name }}</span>
                            <span class="fw-bold fs-3">{{ $planning->date_depart->format('H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold fs-3">{{ $planning->userRailwayLigne->railwayLigne->end->name }}</span>
                            <span class="fw-bold fs-3">{{ $planning->date_arrived->format('H:i') }}</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <img src="{{ $planning->userRailwayLigne->railwayLigne->icon }}" class="w-40px" alt="">
                            <span>{{ $planning->number_travel }}</span>
                        </div>
                    </div>
                </div>
            @endif
            @php
                $planning = $hub->plannings()->where('status', 'arrival')->whereBetween('date_arrived', [now()->startOfDay(), now()->endOfDay()])->first();
                \Carbon\Carbon::setLocale('fr');
            @endphp
            @isset($planning)
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 bg-green-200">
                    <div class="card-header">
                        <h3 class="card-title">Prochain Arrivée</h3>
                        <div class="card-toolbar">
                            @if($planning->status->value == 'initialized')
                                <div class="d-flex align-items-center rounded-3 border border-1 border-primary p-1">
                                    <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                    <span class="fs-4 text-blue-800 fw-semibold"> à l'heure</span>
                                </div>
                            @elseif($planning->status->value == 'retarded')
                                <div
                                    class="d-flex align-items-center rounded-3 bg-orange-600 border border-orange-900 p-2">
                                    <div class="animate__animated animate__flash animate__infinite">
                                        <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                        <span class="fs-4 text-blue-800 fw-semibold"> Retardé</span>
                                    </div>
                                </div>
                            @elseif($planning->status->value == 'canceled')
                                <div class="d-flex align-items-center rounded-3 bg-red-600 border border-red-900 p-2">
                                    <div class="">
                                        <i class="fa-solid fa-clock-four text-white me-2 fs-3"></i>
                                        <span class="fs-4 text-white fw-semibold"> Annulé</span>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex align-items-center rounded-3 border border-primary p-1">
                                    <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                    <span class="fs-4 text-blue-800 fw-semibold"> Départ Imminent</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span
                                class="fw-bold fs-3">{{ $planning->userRailwayLigne->railwayLigne->start->name }}</span>
                            <span class="fw-bold fs-3">{{ $planning->date_depart->format('H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold fs-3">{{ $planning->userRailwayLigne->railwayLigne->end->name }}</span>
                            <span class="fw-bold fs-3">{{ $planning->date_arrived->format('H:i') }}</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <img src="{{ $planning->userRailwayLigne->railwayLigne->icon }}" class="w-40px" alt="">
                            <span>{{ $planning->number_travel }}</span>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
    <div class="card shadow-sm mb-5">
        <div class="card-header justify-content-start align-items-center">
            <div class="symbol symbol-40px bg-gray-100 me-3">
                <img src="{{ Storage::url('icons/railway/hub.png') }}" alt="">
            </div>
            <span class="fw-bold fs-1">Informations</span>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                <span class="badge bg-orange-600 text-white me-3">Hub</span>
                <span class="fw-bold fs-3">{{ $hub->railwayHub->gare->name }} / <x-icon
                        name="flag-country-{{ \Str::limit(\Str::lower($hub->railwayHub->gare->pays), 2, '') }}"
                        class="w-25px h-25px"/> France</span>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                        <span>Date d'achat: </span>
                        <span
                            class="fw-bold">{{ \Carbon\Carbon::parse($hub->date_achat)->format('d/m/Y à H:i') }}</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                        <span>Passagers Annuel: </span>
                        <span
                            class="fw-bold">{{ $hub->getSumPassengers('unique', now()->startOfYear(), now()) + $hub->getSumPassengers('first', now()->startOfYear(), now()) + $hub->getSumPassengers('second', now()->startOfYear(), now()) }}</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                        <span>Performance du HUB: </span>
                        {!! $hub->getRatioPerformance() !!}
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                        <span>Kilomètre de ligne sur ce hub: </span>
                        <span class="fw-bold">{{ $hub->getLigneKilometer() }} Km</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                        <span>Taxe cumulé: </span>
                        <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getTaxe()) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-5">
        <div class="card-header justify-content-start align-items-center">
            <div class="symbol symbol-40px bg-gray-100 me-3">
                <img src="{{ Storage::url('icons/railway/hub.png') }}" alt="">
            </div>
            <span class="fw-bold fs-1">Statistiques</span>
        </div>
        <div class="card-body">
            <div class="fw-bold fs-4">Chiffre d'affaire</div>
            <div class="row mb-4">
                <div class="col-8">
                    <div class="d-flex align-item-center justify-content-between mb-2 bg-gray-100 p-2 rounded">
                        <span class="">Aujourd'hui</span>
                        <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getCA(now(), now())) }}</span>
                    </div>
                    <div class="d-flex align-item-center justify-content-between mb-2 bg-gray-100 p-2 rounded">
                        <span class="">Hier</span>
                        <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getCA(now()->subDay(), now()->subDay())) }}</span>
                    </div>
                </div>
            </div>
            <div class="fw-bold fs-4">Bénéfices</div>
            <div class="row mb-4">
                <div class="col-8">
                    <div class="d-flex align-item-center justify-content-between mb-2 bg-gray-100 p-2 rounded">
                        <span class="">Aujourd'hui</span>
                        <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getBenefice(now(), now())) }}</span>
                    </div>
                    <div class="d-flex align-item-center justify-content-between mb-2 bg-gray-100 p-2 rounded">
                        <span class="">Hier</span>
                        <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getBenefice(now()->subDay(), now()->subDay())) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-5">
        <div class="card-header justify-content-start align-items-center">
            <div class="symbol symbol-40px bg-gray-100 me-3">
                <img src="{{ Storage::url('icons/railway/hub.png') }}" alt="">
            </div>
            <span class="fw-bold fs-1">Résumé Financier</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-lg-6 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Détail financier</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span>Chiffre d'affaire: </span>
                                <span class="">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getCA()) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span>Frais Electrique: </span>
                                <span
                                    class="text-danger">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getFraisElectrique()) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span>Frais Gasoil: </span>
                                <span
                                    class="text-danger">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getFraisCarburant()) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Nombre de passager</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span>Première Classe: </span>
                                <span class="">{{ $hub->getSumPassengers('first') }} P</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span>Seconde Classe: </span>
                                <span class="">{{ $hub->getSumPassengers('second') }} P</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span>Unique (TER): </span>
                                <span class="">{{ $hub->getSumPassengers('unique') }} P</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span class="fw-bold">Total: </span>
                                <span class="">{{ $hub->getSumPassengers('unique') + $hub->getSumPassengers('unique') + $hub->getSumPassengers('second') }} P</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Détail des incidents</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span>Nombre d'incident (30 Jours): </span>
                                <span class="">{{ $hub->getCountIncidents(now()->subDays(30), now()) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span>Cout des incidents (30 jours): </span>
                                <span
                                    class="">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getAmountIncident(now()->subDays(30), now())) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span>Trajet non effectuer: </span>
                                <span class="">{{ $hub->getCountCanceledTravel() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
