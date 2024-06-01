<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="d-flex flex-wrap w-100 justify-content-around align-items-center">
                @foreach($allDates as $date)
                <div wire:click="selectDate('{{ $date->startOfDay() }}')" class="d-flex flex-column justify-content-center align-items-center p-3 bg-hover-light-dark text-active-white bg-active-primary {{ $selectedDate == $date ? "active" : "" }}">
                    <span class="fw-bold">{{ now()->startOfDay() == $date ? "Aujourd'hui" : "" }}</span>
                    <span>{{ $date->format("d/m/Y") }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table table-row-bordered table-row-gray-300 rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                    <thead>
                        <tr>
                            <th><span class="badge badge badge-success">Rame</span> </th>
                            <th><span class="badge badge badge-primary">Ligne</span> </th>
                            <th><span class="badge badge badge-primary">Départ / Arrivée</span> </th>
                            <th><span class="badge badge badge-primary">Transport</span> </th>
                            <th><span class="badge badge badge-primary">Chiffre d'affaire</span> </th>
                            <th><span class="badge badge badge-primary">Résultat</span> </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody wire:poll.visible.60s>
                        @if(count($plannings) == 0)
                            <tr>
                                <td colspan="7">
                                    <x-base.is-null
                                        text="Aucun trajets disponible pour ce jour" />
                                </td>
                            </tr>
                        @else
                            @foreach($plannings as $planning)
                                <tr
                                    class="{{ $planning->status->value === 'initialized' ? 'bg-gray-200 opacity-25' : '' }} {{ $planning->incident_niveau_max == 'middle' ? 'bg-orange-100' : ($planning->incident_niveau_max == 'critical' ? 'bg-red-100' : '') }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $planning->status->value == 'initialized' ? 'Ce trajet n\'est pas encore effectuer' : '' }} {{ $planning->incident_niveau_max == 'middle' ? 'Ce trajet à connu un incident mineur' : ($planning->incident_niveau_max == 'critical' ? 'Trajet non effectuer, un incident majeur est survenue' : '') }}">
                                    <td>{{ $planning->userRailwayEngine->number }} / {{ $planning->userRailwayEngine->railwayEngine->name }}</td>
                                    <td>{{ $planning->userRailwayLigne->railwayLigne->start->abr }}/{{ $planning->userRailwayLigne->railwayLigne->end->abr }}</td>
                                    <td>{{ \Carbon\Carbon::parse($planning->date_depart)->format('H:i') }} / {{ \Carbon\Carbon::parse($planning->date_arrived)->format('H:i') }}</td>
                                    <td>{{ $planning->userRailwayEngine->railwayEngine->technical->nb_marchandise }} P</td>
                                    <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->getCA()) }}</td>
                                    <td>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->getResultat()) }}</td>
                                    <td>
                                        @if($planning->incident_niveau_max == 'critical')
                                            <i class="fa-solid fa-exclamation-triangle text-red-500 fs-3 animate__animated animate__flash animate__infinite"
                                               data-bs-toggle="popover"
                                               data-bs-placement="left"
                                               data-bs-custom-class="popover-critical"
                                               data-bs-html="true"
                                                data-bs-content="<div class='d-flex flex-column'><div class='d-flex justify-content-between mb-1'><span class='fw-bold'>Type d'incident</span><span>{{ Str::ucfirst($planning->incidents()->where('niveau', 3)->first()->type_incident->value) }}</span></div><div class='d-flex justify-content-between mb-1'><span class='fw-bold'>Survenue à </span><span>{{ $planning->incidents()->where('niveau', 3)->first()->created_at->format('H:i') }}</span></div><div class='d-flex justify-content-between mb-2'><span class='fw-bold'>Problème rencontrer </span><span>{{ $planning->incidents()->where('niveau', 3)->first()->designation }}</span></div><div class='d-flex'>{{ $planning->incidents()->where('niveau', 3)->first()->note }}</div></div>"
                                                title="<strong>Niveau: </strong><span class='text-red-600'>Majeur</span>"></i>
                                        @elseif($planning->incident_niveau_max == 'middle')
                                            <i class="fa-solid fa-exclamation-triangle text-orange-500 fs-3"
                                               data-bs-toggle="popover"
                                               data-bs-placement="left"
                                               data-bs-custom-class="popover-warning"
                                               data-bs-html="true"
                                                title="<strong>Niveau: </strong><span class='text-yellow-600'>Mineur</span>"
                                                data-bs-content="<div class='d-flex flex-column'><div class='d-flex justify-content-between mb-1'><span class='fw-bold'>Type d'incident</span><span>{{ Str::ucfirst($planning->incidents()->where('niveau', 2)->first()->type_incident->value) }}</span></div><div class='d-flex justify-content-between mb-1'><span class='fw-bold'>Survenue à </span><span>{{ $planning->incidents()->where('niveau', 2)->first()->created_at->format('H:i') }}</span></div><div class='d-flex justify-content-between mb-2'><span class='fw-bold'>Problème rencontrer </span><span>{{ $planning->incidents()->where('niveau', 2)->first()->designation }}</span></div><div class='d-flex'>{{ $planning->incidents()->where('niveau', 2)->first()->note }}</div></div>"></i>
                                        @endif
                                            <a href="{{ route('network.travel.show', $planning->id) }}" class="btn btn-sm btn-outline btn-icon btn-outline-primary"><i class="fa-solid fa-eye"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
