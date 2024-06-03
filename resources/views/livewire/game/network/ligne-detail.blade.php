<div class="row">
    <div class="col-sm-12 col-lg-9 mb-5">
        <div class="card shadow-sm mb-5">
            <div class="card-header justify-content-start align-items-center">
                <div class="symbol symbol-40px bg-gray-100 me-3">
                    <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                </div>
                <span class="fw-bold fs-1">Informations</span>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-blue-600 text-white me-3">Ligne</span>
                    <span class="fw-bold fs-3">{{ $ligne->railwayLigne->start->abr }} / {{ $ligne->railwayLigne->end->abr }}</span>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                            <span>Date d'achat: </span>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($ligne->date_achat)->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                            <span>Rame affecté: </span>
                            <span class="fw-bold">{{ $ligne->userRailwayEngine()->count() }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                            <span>Nombre de trajet hebdomadaire: </span>
                            <span class="fw-bold">{{ $ligne->plannings()->whereBetween('date_depart', [now()->subDays(7)->startOfDay(), now()->endOfDay()])->count() }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                            <span>Hub de départ: </span>
                            <span class="fw-bold">{{ $ligne->railwayLigne->start->name }} / <x-icon name="flag-country-{{ \Str::limit(\Str::lower($ligne->railwayLigne->start->pays), 2, '') }}" class="w-25px h-25px" /> {{ $ligne->railwayLigne->start->pays }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                            <span>Distance: </span>
                            <span class="fw-bold">{{ $ligne->railwayLigne->distance }} Km</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                            <span>Temps de trajet: </span>
                            <span class="fw-bold">{{ now()->startOfDay()->addMinutes($ligne->railwayLigne->time_min)->format('H:i:s') }}</span>
                        </div>
                        @if($ligne->plannings()->whereBetween('date_depart', [now(), now()->endOfDay()])->orderBy('date_depart', 'asc')->first())
                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                            <span>Prochain départ: </span>
                            <span class="fw-bold">{{ $ligne->plannings()->whereBetween('date_depart', [now(), now()->endOfDay()])->orderBy('date_depart', 'asc')->first()->date_depart->format('H:i:s') }}</span>
                        </div>
                        @endif
                        <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                            <span>Hub d'arrivée: </span>
                            <span class="fw-bold">{{ $ligne->railwayLigne->end->name }} / <x-icon name="flag-country-{{ \Str::limit(\Str::lower($ligne->railwayLigne->end->pays), 2, '') }}" class="w-25px h-25px" /> {{ $ligne->railwayLigne->end->pays }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-5">
            <div class="card-header justify-content-start align-items-center">
                <div class="symbol symbol-40px bg-gray-100 me-3">
                    <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                </div>
                <span class="fw-bold fs-1">Statistiques</span>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column mb-10">
                    <div class="fw-bold fs-4">Chiffre d'affaire</div>
                    <div class="row">
                        <div class="col-6 d-flex justify-content-between">
                            <span>Aujourd'hui</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCA(now(), now())) }}</span>
                        </div>
                        <div class="col-6 d-flex justify-content-between">
                            <span>Hier</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCA(now()->subDay(), now()->subDay())) }}</span>
                        </div>
                    </div>
                    <div class="separator my-2"></div>
                    <div class="fw-bold fs-4">Coût</div>
                    <div class="row">
                        <div class="col-6 d-flex justify-content-between">
                            <span>Aujourd'hui</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCout(now(), now())) }}</span>
                        </div>
                        <div class="col-6 d-flex justify-content-between">
                            <span>Hier</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCout(now()->subDay(), now()->subDay())) }}</span>
                        </div>
                    </div>
                    <div class="separator my-2"></div>
                    <div class="fw-bold fs-4">Revenus Auxiliaire</div>
                    <div class="row">
                        <div class="col-6 d-flex justify-content-between">
                            <span>Aujourd'hui</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getRevenusAux(now(), now())) }}</span>
                        </div>
                        <div class="col-6 d-flex justify-content-between">
                            <span>Hier</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getRevenusAux(now()->subDay(), now()->subDay())) }}</span>
                        </div>
                    </div>
                    <div class="separator my-2"></div>
                    <div class="fw-bold fs-4">Bénéfice des trajets</div>
                    <div class="row">
                        <div class="col-6 d-flex justify-content-between">
                            <span>Aujourd'hui</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getBenefice(now(), now())) }}</span>
                        </div>
                        <div class="col-6 d-flex justify-content-between">
                            <span>Hier</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getBenefice(now()->subDay(), now()->subDay())) }}</span>
                        </div>
                    </div>
                    <div class="separator my-2"></div>
                    <div class="fw-bold fs-4">Coût des incidents</div>
                    <div class="row">
                        <div class="col-6 d-flex justify-content-between">
                            <span>Aujourd'hui</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCoutIncident(now(), now())) }}</span>
                        </div>
                        <div class="col-6 d-flex justify-content-between">
                            <span>Hier</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCoutIncident(now()->subDay(), now()->subDay())) }}</span>
                        </div>
                    </div>
                </div>
                <table class="table table table-row-bordered table-row-gray-800 rounded-4 bg-yellow-400 table-striped gap-5 gs-5 gy-5 gx-5 align-middle mb-10">
                    <thead class="fw-bold">
                    <tr>
                        <th>Prévision</th>
                        <th>
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span class="fw-bold text-blue-300">Aujourd'hui</span>
                                <span>{{ \Carbon\Carbon::today()->format('d/m/Y') }}</span>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span class="fw-bold text-blue-300">J+1</span>
                                <span>{{ \Carbon\Carbon::today()->addDay()->format('d/m/Y') }}</span>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span class="fw-bold text-blue-300">J+2</span>
                                <span>{{ \Carbon\Carbon::today()->addDays(2)->format('d/m/Y') }}</span>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span class="fw-bold text-blue-300">J+3</span>
                                <span>{{ \Carbon\Carbon::today()->addDays(3)->format('d/m/Y') }}</span>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span class="fw-bold text-blue-300">J+4</span>
                                <span>{{ \Carbon\Carbon::today()->addDays(4)->format('d/m/Y') }}</span>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span class="fw-bold text-blue-300">J+5</span>
                                <span>{{ \Carbon\Carbon::today()->addDays(5)->format('d/m/Y') }}</span>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="text-end">
                        <td class="text-start fw-semibold fst-italic">Chiffre d'affaire</td>
                        <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getPrevCA(now(), now())) }}</td>
                        <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getPrevCA(now()->addDay(), now()->addDay())) }}</td>
                        <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getPrevCA(now()->addDays(2), now()->addDays(2))) }}</td>
                        <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getPrevCA(now()->addDays(3), now()->addDays(3))) }}</td>
                        <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getPrevCA(now()->addDays(4), now()->addDays(4))) }}</td>
                        <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getPrevCA(now()->addDays(5), now()->addDays(5))) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card shadow-sm mb-5">
            <div class="card-header ">
                <div class="card-title">
                    <div class="symbol symbol-40px bg-gray-100 me-3">
                        <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                    </div>
                    <span class="fw-bold fs-1">Gestion des tarifs</span>
                </div>
                <div class="card-toolbar">
                    <a href="" class="btn btn-flex bg-purple-600 bg-hover-info">
                        <span class="symbol symbol-35px me-2">
                            <img src="{{ Storage::url('icons/railway/financial.png') }}" alt="">
                        </span>
                        <span class="text-white">Tarif de la ligne</span>
                    </a>
                </div>
            </div>
            <div class="card-body" x-data="{daySelected: 'today'}">
                <div class="d-flex">
                    <div class="form-check form-check-custom form-check-solid form-check-inline">
                        <input class="form-check-input" x-model="daySelected" name="daySelected" value="today" type="radio" checked/>
                        <label class="form-check-label" for="today">
                            Aujourd'hui
                        </label>
                    </div>
                    <div class="form-check form-check-custom form-check-solid form-check-inline">
                        <input class="form-check-input" x-model="daySelected" name="daySelected" value="yesterday" type="radio" />
                        <label class="form-check-label" for="yesterday">
                            Hier
                        </label>
                    </div>
                </div>
                <div>
                    <table class="table table table-row-bordered table-row-gray-800 rounded-4 bg-gray-400 table-striped gap-5 gs-5 gy-5 gx-5 align-middle mb-10">
                        <thead>
                        <tr>
                            <th></th>
                            @if($ligne->railwayLigne->type->value == 'ter')
                                <th>Classe Unique</th>
                            @else
                                <th>Première Classe</th>
                                <th>Seconde Classe</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody x-show="daySelected === 'today'">
                        @foreach($ligne->tarifs()->whereDate('date_tarif', \Carbon\Carbon::today())->get() as $tarif)
                            <tr>
                                <td>Demande</td>
                                @if($ligne->railwayLigne->type->value == 'ter')
                                    <td>{{ $tarif->demande }} P</td>
                                @else
                                    <td>{{ $tarif->type_tarif->value == 'first' ? $tarif->demande : '' }}</td>
                                    <td>{{ $tarif->type_tarif->value == 'second' ? $tarif->demande : '' }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Offre</td>
                                @if($ligne->railwayLigne->type->value == 'ter')
                                    <td>{{ $tarif->offre }} P</td>
                                @else
                                    <td>{{ $tarif->type_tarif->value == 'first' ? $tarif->offre : '' }}</td>
                                    <td>{{ $tarif->type_tarif->value == 'second' ? $tarif->offre : '' }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Prix Moyen</td>
                                @if($ligne->railwayLigne->type->value == 'ter')
                                    <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($tarif->price) }}</td>
                                @else
                                    <td>{{ $tarif->type_tarif->value == 'first' ? \Vortechstudio\Helpers\Facades\Helpers::eur($tarif->price) : '' }}</td>
                                    <td>{{ $tarif->type_tarif->value == 'second' ? \Vortechstudio\Helpers\Facades\Helpers::eur($tarif->price) : '' }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                        <tbody x-show="daySelected === 'yesterday'">
                        @foreach($ligne->tarifs()->whereDate('date_tarif', \Carbon\Carbon::yesterday())->get() as $tarif)
                            <tr>
                                <td>Demande</td>
                                @if($ligne->railwayLigne->type->value == 'ter')
                                    <td>{{ $tarif->demande }} P</td>
                                @else
                                    <td>{{ $tarif->type_tarif->value == 'first' ? $tarif->demande : '' }}</td>
                                    <td>{{ $tarif->type_tarif->value == 'second' ? $tarif->demande : '' }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Offre</td>
                                @if($ligne->railwayLigne->type->value == 'ter')
                                    <td>{{ $tarif->offre }} P</td>
                                @else
                                    <td>{{ $tarif->type_tarif->value == 'first' ? $tarif->offre : '' }}</td>
                                    <td>{{ $tarif->type_tarif->value == 'second' ? $tarif->offre : '' }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Prix Moyen</td>
                                @if($ligne->railwayLigne->type->value == 'ter')
                                    <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($tarif->price) }}</td>
                                @else
                                    <td>{{ $tarif->type_tarif->value == 'first' ? \Vortechstudio\Helpers\Facades\Helpers::eur($tarif->price) : '' }}</td>
                                    <td>{{ $tarif->type_tarif->value == 'second' ? \Vortechstudio\Helpers\Facades\Helpers::eur($tarif->price) : '' }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        <div class="card shadow-sm mb-5">
            <div class="card-header">
                <div class="card-title">
                    <div class="symbol symbol-40px bg-gray-100 me-3">
                        <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                    </div>
                    <span class="fw-bold fs-1">Résumé Financier sur 7 jours</span>
                </div>
                <div class="card-toolbar">
                    <a href="" class="btn btn-flex bg-orange-600 bg-hover-warning">
                                            <span class="symbol symbol-35px me-2">
                                                <img src="{{ Storage::url('icons/railway/accounting.png') }}" alt="">
                                            </span>
                        <span class="text-white">Détail comptable</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-6 mb-5">
                        <x-base.title title="Détails Financiers" />
                        <div class="d-flex flex-row justify-content-between">
                            <span>Chiffre d'affaires</span>
                            <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCA(now()->subDays(7), now())) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between fst-italic ps-5">
                            <span>Dont Chiffres d'affaires billetterie</span>
                            <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCABilletterie(now()->subDays(7), now())) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between fst-italic ps-5 mb-3">
                            <span>Dont revenus auxilliaires</span>
                            <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getRevenusAux(now()->subDays(7), now())) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between text-danger">
                            <span>Cout des trajets</span>
                            <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCout(now()->subDays(7), now())) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between text-danger fst-italic ps-5">
                            <span>Dont frais électrique</span>
                            <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getFrais('electricite', now()->subDays(7), now())) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between text-danger fst-italic ps-5">
                            <span>Dont frais de gasoil</span>
                            <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getFrais('gasoil', now()->subDays(7), now())) }}</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 mb-5">
                        <x-base.title title="Nombre de passagers" />
                        @if($ligne->railwayLigne->type->value == 'ter')
                            <div class="d-flex flex-row justify-content-between">
                                <span>Uniques</span>
                                <span class="fw-bold">{{ $ligne->sumPassenger('unique') }} P</span>
                            </div>
                        @else
                            <div class="d-flex flex-row justify-content-between">
                                <span>Première Classe</span>
                                <span class="fw-bold">{{ $ligne->sumPassenger('first') }} P</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between">
                                <span>Seconde Classe</span>
                                <span class="fw-bold">{{ $ligne->sumPassenger('second') }} P</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-12 col-lg-6 mb-5">
                        <div class="d-flex flex-row justify-content-between">
                            <span>Résultat des trajets</span>
                            <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getResultat(now()->subDays(7), now())) }}</span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 mb-5">
                        <div class="d-flex flex-row justify-content-between">
                            <span>Coût des incidents</span>
                            <span class="fw-bold text-danger">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCoutIncident(now()->subDays(7), now())) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-5">
            <div class="card-header">
                <div class="card-title">
                    <div class="symbol symbol-40px bg-gray-100 me-3">
                        <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                    </div>
                    <span class="fw-bold fs-1">Rame sur cette ligne</span>
                </div>
            </div>
            <div class="card-body">
                @livewire('game.engine.engine-list', ["type" => "ligne", "ligne" => $ligne])
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-3 mb-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="timeline-label">
                    @foreach($ligne->railwayLigne->stations as $station)
                        <div class="timeline-item">
                            <div class="timeline-label fw-bold text-gray-800 fs-6">&nbsp;</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless {{ $ligne->railwayLigne->start->name == $station->gare->name ? 'text-success fs-3x' : ($ligne->railwayLigne->end->name == $station->gare->name ? 'text-danger fs-3x' : 'text-gray-500 fs-1') }}"></i>
                            </div>
                            <div class="{{ $ligne->railwayLigne->start->name == $station->gare->name || $ligne->railwayLigne->end->name == $station->gare->name ? 'fw-bold fs-3' : 'fw-normal fs-4' }} timeline-content ps-3">
                                {{ $station->gare->name }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
