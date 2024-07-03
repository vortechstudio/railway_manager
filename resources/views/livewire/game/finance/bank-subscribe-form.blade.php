<div>
    <form action="" wire:submit="subscribe" x-data="">
        <div class="row">
            <div class="col-sm-12 col-lg-8 mb-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-10">
                                    <label for="selectedBank" class="form-label required">Banque</label>
                                    <select name="selectedBank" id="selectedBank" wire:model.live="selectedBank" class="form-select" data-control="select2" data-placeholder="---  Selectionner une banque ---" required>
                                        <option></option>
                                        @foreach(\App\Models\Railway\Config\RailwayBanque::all() as $banque)
                                            @if($banque->is_unlocked)
                                                <option value="{{ $banque->id }}">{{ $banque->name }} ({{ $banque->latest_flux }} %)</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if($selectedBank)
                                <div class="col-6">
                                    <div class="mb-10">
                                        <label for="typeEmprunt" class="form-label required">Type d'emprunt</label>
                                        <select name="typeEmprunt" id="typeEmprunt" wire:model.live="typeEmprunt" class="form-select" required>
                                            <option>---  Selectionner un type d'emprunt ---</option>
                                            <option value="express">Emprunt Express ({{ Helpers::eur($bq->express_base) }})</option>
                                            <option value="market">Marché Financier ({{ Helpers::eur($bq->public_base) }})</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if($typeEmprunt && $typeEmprunt == 'express')
                            @php
                                $pending = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'express')->where('status', 'pending')->where('railway_banque_id', $bq->id)->sum('amount_emprunt');
                                $charge = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'express')->where('status', 'pending')->where('railway_banque_id', $bq->id)->sum('charge');
                                $reste = $bq->express_base - ($pending - $charge);
                            @endphp
                            <div class="row">
                                <div class="col">
                                    <div class="mb-10">
                                        <label class="form-label required">Montant Souhaité</label>
                                        <input type="text" class="form-control" id="amountRequest" name="amountRequest" wire:model.live.debounce.500ms="amountRequest" required/>
                                        <span>Montant restant accessible: {{ Helpers::eur($reste) }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-10">
                                        <label for="empruntDuration" class="form-label required">Durée de l'emprunt</label>
                                        <select name="empruntDuration" id="empruntDuration" wire:model.live="empruntDuration" class="form-select" required>
                                            <option>--- Selectionnez une durée d'emprunt</option>
                                            @for($i = 10; $i <= 50; $i++)
                                                <option value="{{ $i }}">{{ $i }} Semaines</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($typeEmprunt && $typeEmprunt == 'market')
                            @php
                                $pending = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'marche')->where('status', 'pending')->where('railway_banque_id', $bq->id)->sum('amount_emprunt');
                                $charge = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'marche')->where('status', 'pending')->where('railway_banque_id', $bq->id)->sum('charge');
                                $reste = $bq->public_base - ($pending - $charge);
                            @endphp
                            <div class="row">
                                <div class="col">
                                    <div class="mb-10">
                                        <label class="form-label required">Montant Souhaité</label>
                                        <input type="text" class="form-control" id="amountRequest" name="amountRequest" wire:model.live.debounce.500ms="amountRequest" required/>
                                        <span>Montant restant accessible: {{ Helpers::eur($reste) }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-10">
                                        <label for="empruntDuration" class="form-label required">Durée de l'emprunt</label>
                                        <select name="empruntDuration" id="empruntDuration" wire:model.live="empruntDuration" class="form-select" required>
                                            <option>--- Selectionnez une durée d'emprunt</option>
                                            @for($i = 10; $i <= 50; $i++)
                                                <option value="{{ $i }}">{{ $i }} Semaines</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-10">
                                        <label class="form-label required">Croissance espérer</label>
                                        <input type="text" class="form-control" id="croissance" name="croissance" wire:model.live.debounce.500ms="croissance" required/>
                                        <span>En pourcentage</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 mb-5">
                @if($selectedBank && $typeEmprunt)
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Souscription</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Banque</span>
                                <span>{{ $bq->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Type d'emprunt</span>
                                <span>{{ $typeEmprunt }}</span>
                            </div>
                            @if($amountRequest)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Montant Souhaité</span>
                                    <span>{{ Helpers::eur($amountRequest) }}</span>
                                </div>
                            @endif
                            @if($empruntDuration)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Durée</span>
                                    <span>{{ $empruntDuration }} Semaines</span>
                                </div>
                            @endif
                            <div class="separator my-5"></div>
                            @if($amountTotal)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Charge de l'emprunt</span>
                                    <span>{{ Helpers::eur($charge) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Montant total de l'emprunt</span>
                                    <span class="fw-bold">{{ Helpers::eur($amountTotal) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>A payer toutes les semaines</span>
                                    <span class="fw-bold">{{ Helpers::eur($amountHebdo) }} / <small>Semaines</small></span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($amountTotal)
                            <button class="btn btn-success" type="submit" wire:loading.attr="disabled" wire:target="subscribe">
                                <span wire:loading.class="d-none" wire:target="subscribe"><i class="fa-solid fa-check-circle me-2"></i> Souscrire</span>
                                <span class="d-none" wire:loading.class.remove="d-none" wire:target="subscribe">
                                <div class="spinner-border me-2" role="status">
                                  <span class="visually-hidden">Loading...</span>
                                </div>
                                Patientez...
                            </span>
                            </button>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>

<x-scripts.pluginForm />
