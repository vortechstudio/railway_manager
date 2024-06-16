<div>
    <div class="d-flex align-items-center mb-10">
        <div class="d-flex flex-wrap w-75 rounded-2 bg-gray-200 shadow-lg p-5 me-5 gap-3">
            @foreach($hub->publicities as $publicity)
                @for($i = 0; $i <= $publicity->nb_slot; $i++)
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
            <h3 class="card-title">Contrat publicitaires</h3>
            <div class="card-toolbar">
                <button data-bs-toggle="modal" data-bs-target="#modalpublicities" type="button" class="btn btn-sm btn-light">
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
                @if(count($hub->publicities) > 0)
                    @foreach($hub->publicities as $publicity)
                        <tr>
                            <td>{{ $publicity->societe }}</td>
                            <td>{{ $publicity->end_at->format('d/m/Y') }}</td>
                            <td>{{ Helpers::eur($publicity->ca_daily) }}</td>
                            <td>
                                <button wire:click="revoque({{ $publicity->id }})" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-xmark text-white me-2"></i> Révoquer
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">
                            <x-base.is-null text="Aucun contrat publicitaire en cours" />
                        </td>
                    </tr>
                @endif
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" class="text-end fw-bold">Total CA Previsionnel</td>
                    <td class="fs-3 fw-bold">{{ Helpers::eur($this->hub->publicities()->sum('ca_daily')) }} / par jours</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="modalpublicities">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Contrat publicitaires potentiel</h3>

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
                                        <button wire:click="select('{{ $contract['societe'] }}', {{ $contract['nb_slot'] }}, {{ $contract['contract_duration_day'] }}, {{ $contract['ca_prev'] }}, {{ $contract['amount_invest'] }})" type="button" class="btn btn-sm btn-primary">
                                            Selectionner
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                                        <span>Montant Investie</span>
                                        <span>{{ Helpers::eur($contract['amount_invest']) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                                        <span>Nombre de slot réservé</span>
                                        <span>{{ $contract['nb_slot'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                                        <span>Durée du contrat</span>
                                        <span>{{ $contract['contract_duration_day'] }} jours</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-2 p-5 mb-2">
                                        <span>CA Journalier</span>
                                        <span>{{ Helpers::eur($contract['ca_prev']) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
