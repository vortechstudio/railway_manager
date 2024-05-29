@if($showing == 'simple')
    <div id="simple" class="rounded bg-grey-600 border border-5 border-gray-400">
        <div class="d-flex flex-column w-100">
            @foreach($incidents as $incident)
                <div class="d-flex flex-wrap align-items-center" x-data="{showIncident: false}">
                    <div class="d-flex flex-row h-150px border-bottom border-gray-500">
                        <div class="d-flex flex-column justify-content-center w-15 align-items-center border-gray-500 border-end-dashed p-5">
                            <img class="mb-1 img-fluid" src="{{ $incident->railwayPlanning->userRailwayEngine->railwayEngine->getFirstImage($incident->railwayPlanning->userRailwayEngine->railwayEngine->id) }}" alt="">
                            <span class="fs-4 text-white">{{ $incident->railwayPlanning->userRailwayEngine->railwayEngine->name }} - {{ $incident->railwayPlanning->userRailwayEngine->number }}</span>
                            <small class="text-white">{{ $incident->railwayPlanning->number_travel }}</small>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center border-gray-500 border-end-dashed w-25 p-5">
                            <div class="text-white fs-3">Ligne</div>
                            <span class="fs-2 text-white fw-bolder text-center">{{ $incident->railwayPlanning->userRailwayLigne->railwayLigne->name }}</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center border-gray-500 border-end-dashed p-5 w-200px">
                            <div class="text-white fs-3">{{ $incident->railwayPlanning->date_depart->format("d/m/Y") }}</div>
                            <span class="fs-2 text-white fw-bolder" data-bs-toggle="tooltip" title="Heure de départ">{{ $incident->railwayPlanning->date_depart->format("H:i") }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center p-0">
                            <img src="{{ $incident->image_type }}" alt="" class="w-200px ps-5 opacity-50 shadow-lg  me-10" data-bs-toggle="tooltip" title="{{ $incident->type_incident->name }}">
                            <div class="d-flex flex-column">
                                <button @click="showIncident = ! showIncident" class="btn btn-sm btn-primary btn-flex rounded-4 mb-2 showIncident">
                                    <img src="{{ Storage::url('services/'.$service->id.'/game/icons/warning_'.$incident->niveau_indicator.'.png') }}" alt="" class="w-30px me-2 animation-blink">
                                    <span>Détail de l'incident</span>
                                </button>
                                <a href="" class="btn btn-sm btn-primary btn-flex rounded-4">
                                    <img src="{{ Storage::url('icons/railway/train.png') }}" alt="" class="w-30px me-2">
                                    <span>Détail de l'engin</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div x-show="showIncident">
                        <div class="d-flex flex-row h-150px border-bottom border-gray-500">
                            <div class="d-flex flex-column justify-content-center w-15 align-items-center border-gray-500 border-end-dashed p-5">
                                <img class="mb-1 img-fluid" src="{{ $incident->railwayPlanning->userRailwayEngine->railwayEngine->getFirstImage($incident->railwayPlanning->userRailwayEngine->railwayEngine->id) }}" alt="">
                                <span class="fs-4 text-white">{{ $incident->railwayPlanning->userRailwayEngine->railwayEngine->name }} - {{ $incident->railwayPlanning->userRailwayEngine->number }}</span>
                                <small class="text-white">{{ $incident->railwayPlanning->number_travel }}</small>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center border-gray-500 border-end-dashed w-25 p-5">
                                <div class="text-white fs-3">Montant des réparation</div>
                                <span class="fs-3 text-danger fw-bolder text-center">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($incident->amount_reparation) }}</span>
                            </div>
                            <div class="d-flex flex-row align-items-center border-gray-500 w-100 p-5">
                                <div class="symbol symbol-50px animate__animated animate__flash animate__infinite animate__slow me-5">
                                    <img src="{{ Storage::url('services/'.$service->id.'/game/icons/warning_'.$incident->niveau_indicator.'.png') }}" alt="">
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold text-white opacity-100 mb-2">{!! $incident->designation !!}</span>
                                    <div class="d-flex flex-row mb-3">
                                        <span class="fw-bold">Incidence sur le trafic:</span>
                                        <span>{{ $incident->incidence }}</span>
                                    </div>
                                    <div class="d-flex fst-italic text-white fs-8">{!! $incident->note !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@elseif($showing == 'advanced')
    <div id="advanced" class="rounded bg-grey-600 border border-5 border-gray-400">
        <table id="listIncident" class="table table-bordered table-row-dashed table-row-gray-500 ">
            <tbody>
            @foreach($incidents as $incident)
                <tr class="align-middle fs-4">
                    <td class="min-w-70px">
                        <img src="{{ $incident->railwayPlanning->userRailwayLigne->railwayLigne->icon }}" class="w-50px" alt="">
                    </td>
                    <td class="min-w-100px text-center">
                        <span class="text-white">{{ $incident->railwayPlanning->userRailwayEngine->railwayEngine->name }} - {{ $incident->railwayPlanning->userRailwayEngine->number }}</span>
                    </td>
                    <td class="min-w-100px text-center">
                        <span class="text-white">{{ $incident->railwayPlanning->number_travel }}</span>
                    </td>
                    <td class="min-w-100px text-center">
                        <span class="text-white">{{ $incident->railwayPlanning->date_depart->format("d/m/Y H:i") }}</span>
                    </td>
                    <td class="min-w-100px text-center">
                        <span class="text-white">{{ $incident->railwayPlanning->userRailwayLigne->railwayLigne->name }}</span>
                    </td>
                    <td class="min-w-50px text-center">
                        <img src="{{ $incident->image_type }}" class="w-45px" alt="">
                    </td>
                    <td class="min-w-100px text-end">
                        <span class="text-white">- {{ \Vortechstudio\Helpers\Facades\Helpers::eur($incident->amount_reparation) }}</span>
                    </td>
                    <td class="text-center">
                        <a href="" class="btn btn-icon btn-flush">
                            <img src="{{ Storage::url('icons/railway/train.png') }}" class="w-30px" alt="">
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
