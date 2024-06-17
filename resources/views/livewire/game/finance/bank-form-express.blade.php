<div wire:ignore.self class="modal fade" tabindex="-1" id="express">
    <form action="" wire:submit="save">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <x-base.title title="Votre Banque" />
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-2 mb-5">
                                    <div class="symbol symbol-150px">
                                        <div class="symbol-label">
                                            <img src="{{ $banque->image }}" class="w-90 img-fluid" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-10 mb-5">
                                    <div class="d-flex flex-column mb-2">
                                        <span class="fw-bolder text-gray-300 fs-3hx">{{ $banque->name }}</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-6">
                                            @php
                                                $pending = auth()->user()->railway->userRailwayEmprunts()->where('railway_banque_id', $banque->id)->sum('amount_emprunt');
                                                $reste = $banque->express_base - $pending;
                                            @endphp
                                            <div class="d-flex flex-column mb-5">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>Taux d'intérêt</span>
                                                    <span class="fw-bold">{{ $banque->latest_flux }} %</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>Emprunt Express en cours</span>
                                                    <div class="fw-bold">{{ Helpers::eur($pending) }}</div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>Emprunt Express Maximal</span>
                                                    <div class="fw-bold">{{ Helpers::eur($reste) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Emprunt Express</h3>
                            <div class="card-toolbar gap-3">
                                <button type="submit" class="btn btn-sm btn-success">
                                    Valider
                                </button>
                                <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-icon btn-light">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-10">
                                <label class="form-label required">Montant souhaité</label>
                                <input type="text" class="form-control" id="amount_request" name="amount_request" wire:model="amount_request" required/>
                            </div>

                            <div class="mb-10">
                                <label for="emprunt_duration" class="form-label required">Durée du contrat</label>
                                <select wire:model="emprunt_duration" name="emprunt_duration" id="emprunt_duration" class="form-select" data-control="select2" data-placeholder="---  Durée du contrat ---" required>
                                    <option></option>
                                    @for($i = 10; $i <= 50; $i++)
                                        <option value="{{ $i }}">{{ $i }} Semaines</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push("scripts")
    <x-base.close-modal />
@endpush
