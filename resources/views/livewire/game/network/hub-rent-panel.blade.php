<div>
    <div class="d-flex justify-content-center align-items-center bg-gray-100 rounded-3 p-5 mb-10">
        <ul class="nav nav-pills nav-pills-custom">
            <li class="nav-item me-3 me-lg-6" role="presentation">
                <a href="#commerces" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px active">
                    <i class="fa-solid fa-shop text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Commerces"></i>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
            <li class="nav-item me-3 me-lg-6" role="presentation">
                <a href="#publicities" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px">
                    <i class="fa-solid fa-bullhorn text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Publicité"></i>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
            <li class="nav-item me-3 me-lg-6" role="presentation">
                <a href="#parkings" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px">
                    <i class="fa-solid fa-parking text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Parkings"></i>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="commerces" role="tabpanel">
            <div class="d-flex align-items-center mb-10">
                <div class="d-flex flex-wrap w-75 rounded-2 bg-gray-200 shadow-lg p-5 me-5 gap-3">
                    @foreach($hub->commerces as $commerce)
                        @for($i = 0; $i <= $commerce->nb_slot_commerce; $i++)
                            <div class="symbol symbol-30px">
                                <div class="symbol-label bg-danger">&nbsp;</div>
                            </div>
                        @endfor
                    @endforeach
                    @for($i = 0; $i < $totalSlot - $occupiedSlot; $i++)
                            <div class="symbol symbol-30px">
                                <div class="symbol-label bg-green-500">&nbsp;</div>
                            </div>
                    @endfor

                </div>
                <div class="d-flex flex-column w-25 border border-2 rounded-2 p-5">
                    <div class="d-flex align-items-center mb-2">
                        <div class="symbol symbol-20px me-3">
                            <div class="symbol-label bg-danger"></div>
                        </div>
                        <span>Occupé</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="symbol symbol-20px me-3">
                            <div class="symbol-label bg-green-500"></div>
                        </div>
                        <span>Libre</span>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Contrat Commercials</h3>
                    <div class="card-toolbar">
                        <button data-bs-toggle="modal" data-bs-target="#modalContracts" type="button" class="btn btn-sm btn-light">
                            Demande commercial
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                        <thead>
                        <tr>
                            <th>Société</th>
                            <th>Date de fin de contrat</th>
                            <th>CA Journalier</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($hub->commerces) > 0)
                                @foreach($hub->commerces as $commerce)
                                    <tr>
                                        <td>{{ $commerce->societe }}</td>
                                        <td>{{ $commerce->end_at->format('d/m/Y') }}</td>
                                        <td>{{ Helpers::eur($commerce->ca_daily) }}</td>
                                        <td>
                                            <button wire:click="revoque({{ $commerce->id }})" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-xmark text-white me-2"></i> Révoquer
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">
                                        <x-base.is-null text="Aucun contrat commercial en cours" />
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total CA Previsionnel</td>
                                <td class="fs-3 fw-bold">{{ Helpers::eur($this->hub->commerces()->sum('ca_daily')) }} / par jours</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="modalContracts">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Contrat commercial potentiel</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="d-flex flex-column bg-gray-200 rounded-3 p-5 h-500px scroll">
                        @foreach($contracts as $contract)
                            <div class="card shadow-sm mb-5">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $contract['societe'] }}</h3>
                                    <div class="card-toolbar">
                                        <button wire:click="select('{{ $contract['societe'] }}', {{ $contract['nb_slot_required'] }}, {{ $contract['contract_duration_day'] }}, {{ $contract['ca_prev'] }})" type="button" class="btn btn-sm btn-primary">
                                            Selectionner
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                                        <span>Nombre d'espace requis</span>
                                        <span>{{ $contract['nb_slot_required'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                                        <span>Durée du contrat</span>
                                        <span>{{ $contract['contract_duration_day'] }} jours</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                                        <span>CA Prévisionnel</span>
                                        <span>{{ Helpers::eur($contract['ca_prev']) }} / jour</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <x-base.close-modal />
@endpush
