<div x-data="{card_rentals: true, card_engine: false, card_config: false, card_checkout: false}">
    <form action="" wire:submit="checkout">
        <div class="card shadow-sm" x-show="card_rentals">
            <div class="card-header">
                <h3 class="card-title">Choix du prestataire</h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-5">
                    @foreach($rentals as $rental)
                        <div>
                            <input type="radio" class="btn-check" wire:model.live="selectRental" name="selectRental" value="{{ $rental->id }}" id="engine_{{ Str::snake($rental->name) }}"/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex mb-5" for="engine_{{ Str::snake($rental->name) }}">
                                <div class="card shadow-lg w-100">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $rental->name }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="me-5">
                                                <img src="{{ $rental->image }}" class="w-150px img-thumbnail" alt="">
                                            </div>
                                            <div class="row w-100 justify-content-start">
                                                <div class="col-6">
                                                    <div class="fs-5 fw-bold">Informations</div>
                                                    <ul>
                                                        <li>
                                                            <strong>Type: </strong>
                                                            @foreach(json_decode($rental->type) as $type)
                                                                {{ $type }},
                                                            @endforeach
                                                        </li>
                                                        <li>
                                                            <strong>Durée de contrat: </strong> {{ $rental->contract_duration }} semaines
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end align-items-center">
                    @if($selectRental)
                        <button type="button" x-on:click="card_rentals = false; card_engine = true;" class="btn btn-lg btn-outline btn-outline-secondary">
                            <i class="fa-solid fa-arrow-alt-circle-right me-3"></i>
                            <span>Suivant</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card shadow-sm" x-show="card_engine">
            <div class="card-header">
                <h3 class="card-title">Choix de la rame</h3>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 p-5 mb-5 bg-gray-300 rounded-3 mb-10">
                    <div>
                        <label for="type_transport" class="form-label">Type de transport</label>
                        <select wire:model.live="type_transport" name="type_transport" id="type_transport" class="form-select">
                            <option></option>
                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Engine\RailwayEngineTransportEnum::class)->toArray() as $type)
                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type_energy" class="form-label">Type d'énergie</label>
                        <select wire:model.live="type_energy" name="type_energy" id="type_energy" class="form-select">
                            <option></option>
                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Engine\RailwayEngineEnergyEnum::class)->toArray() as $type)
                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type_train" class="form-label">Type de matériel</label>
                        <select wire:model.live="type_train" name="type_train" id="type_train" class="form-select">
                            <option></option>
                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Engine\RailwayEngineTrainEnum::class)->toArray() as $type)
                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <div class="form-check form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" wire:model.live="price_order" type="radio" value="asc" id="price_order_asc"/>
                            <label class="form-check-label" for="price_order_asc">
                                Prix -
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" wire:model.live="price_order" type="radio" value="desc" id="price_order_desc"/>
                            <label class="form-check-label" for="price_order_desc">
                                Prix +
                            </label>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column gap-5">
                    @isset($engines)
                        @foreach($engines as $engine)
                            <input type="radio" class="btn-check" wire:model.live="selectEngine" name="selectEngine" value="{{ $engine->id }}" id="engine_{{ Str::snake($engine->name) }}"/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary btn-flex p-7 d-flex flex-row justify-content-start align-items-start mb-5" for="engine_{{ Str::snake($engine->name) }}">
                                <div class="card shadow-lg w-100">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $engine->name }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="me-5">
                                                <img src="{{ $engine->getFirstImage($engine->id) }}" class="w-150px img-thumbnail" alt="">
                                            </div>
                                            <div class="row w-100">
                                                <div class="col-6">
                                                    <div class="fs-5 fw-bold">Informations</div>
                                                    <ul>
                                                        <li>Limite d'activité: <strong>{{ (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engine))->maxRuntime() }} Km</strong></li>
                                                        <li>Vitesse d'usure: <strong>5.6%/100h</strong></li>
                                                        <li>Sieges: <strong>{{ $engine->technical->nb_marchandise }} P</strong></li>
                                                        <li>Vitesse: <strong>{{ $engine->technical->velocity }} Km/h</strong></li>
                                                    </ul>
                                                </div>
                                                <div class="col-6 align-items-start">
                                                    <div class="fs-5 fw-bold">Prix</div>
                                                    <ul>
                                                        <li>Prix: <strong>{{ Helpers::eur($engine->price->location) }}</strong> / Semaine</li>
                                                        <li>Caution: <strong>{{ Helpers::eur($engine->price->amount_caution) }}</strong></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    @endisset
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" x-on:click="card_engine = false; card_rentals = true;" class="btn btn-lg btn-outline btn-outline-secondary">
                        <i class="fa-solid fa-arrow-alt-circle-left me-3"></i>
                        <span>Précédent</span>
                    </button>
                    @if($selectEngine)
                        <button type="button" x-on:click="card_engine = false; card_config = true" class="btn btn-lg btn-outline btn-outline-secondary">
                            <i class="fa-solid fa-arrow-alt-circle-right me-3"></i>
                            <span>Suivant</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card shadow-sm" x-show="card_config">
            <div class="card-header">
                <h3 class="card-title">Configuration de la rame et du contrat</h3>
            </div>
            <div class="card-body">
                @isset($engineData)
                    <div class="card shadow-lg mb-5 w-100">
                        <div class="card-header">
                            <h3 class="card-title">{{ $engineData->name }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-5">
                                    <img src="{{ $engineData->getFirstImage($engineData->id) }}" class="w-150px img-thumbnail" alt="">
                                </div>
                                <div class="row w-100">
                                    <div class="col-6">
                                        <div class="fs-5 fw-bold">Informations</div>
                                        <ul>
                                            <li>Limite d'activité: <strong>{{ (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engineData))->maxRuntime() }} Km</strong></li>
                                            <li>Vitesse d'usure: <strong>5.6%/100h</strong></li>
                                            <li>Vitesse: <strong>{{ $engineData->technical->velocity }} Km/h</strong></li>
                                        </ul>
                                    </div>
                                    <div class="col-6 align-items-start">
                                        <div class="fs-5 fw-bold">Prix</div>
                                        <ul>
                                            <li>Prix: <strong>{{ Helpers::eur($engine->price->location) }}</strong> / Semaine</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-base.title title="Composition du train" />
                    <div class="row mb-5">
                        <div class="col-9  h-250px scroll">
                            <div class="d-flex flex-wrap gap-1 w-100 border border-3 rounded-3 p-5">
                                @if($engineData->type_transport->value == 'tgv' || $engineData->type_transport->value == 'ic')
                                    @for($i=0; $i <= (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engineData))->getComposition('first'); $i++)
                                        <i class="fa-solid fa-square fs-3 text-color-tgv"></i>
                                    @endfor
                                        @for($i=0; $i <= (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engineData))->getComposition('second'); $i++)
                                            <i class="fa-solid fa-square fs-3 text-color-ter"></i>
                                        @endfor
                                @else
                                    @for($i=0; $i <= (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engineData))->getComposition('second'); $i++)
                                        <i class="fa-solid fa-square fs-3 text-color-ter"></i>
                                    @endfor
                                @endif
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex flex-column p-5 border rounded-2 ">
                                @if($engineData->type_transport->value == 'tgv' || $engineData->type_transport->value == 'ic')
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-color-tgv text-white">1ere Classe</span>
                                    <span>{{ (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engineData))->getComposition('first') }} P</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-color-ter text-white">2eme Classe</span>
                                    <span>{{ (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engineData))->getComposition('second') }} P</span>
                                </div>
                                @else
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-color-ter text-white">Unique</span>
                                        <span>{{ (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engineData))->getComposition('second') }} P</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <x-base.title title="Configuration du contrat" />
                    <div class="row">
                        <div class="col-sm-12 col-lg-7 mb-5">
                            <div class="mb-10">
                                <label for="qteSemaine" class="form-label required">Durée du contrat</label>
                                <select wire:model.live="qteSemaine" name="qteSemaine" id="qteSemaine" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de matériel ---" required>
                                    <option></option>
                                    @for($i=1; $i <= $rental->contract_duration; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ \Str::plural('semaine', $i) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-10">
                                <label for="selectDeliveryHub" class="form-label required">Durée du contrat</label>
                                <select wire:model.live="selectDeliveryHub" name="selectDeliveryHub" id="selectDeliveryHub" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de matériel ---" required>
                                    <option></option>
                                    @foreach(\App\Models\User\Railway\UserRailwayHub::where('active', true)->get() as $hub)
                                        <option value="{{ $hub->id }}">{{ $hub->railwayHub->gare->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-5 mb-5">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Prélèvement hebdomadaire</span>
                                        <span>{{ Helpers::eur($engineData->price->location) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Caution</span>
                                        <span>{{ Helpers::eur($caution) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total des Frais</span>
                                        <span>{{ $qteSemaine ? Helpers::eur($frais) : '0,00 €' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" x-on:click="card_config = false; card_engine = true;" class="btn btn-lg btn-outline btn-outline-secondary">
                        <i class="fa-solid fa-arrow-alt-circle-left me-3"></i>
                        <span>Précédent</span>
                    </button>
                    @if($qteSemaine && $selectDeliveryHub)
                        <button type="button" x-on:click="card_config = false; card_checkout = true" class="btn btn-lg btn-outline btn-outline-secondary">
                            <i class="fa-solid fa-arrow-alt-circle-right me-3"></i>
                            <span>Suivant</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card shadow-sm" x-show="card_checkout">
            @if($qteSemaine && $engineData)
                <div class="card-header">
                    <h3 class="card-title">Récapitulatif avant location</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center p-5 rounded-3 bg-gray-300 animate__animated animate__fadeInRight">
                        <div class="gap-4">
                            <span class="fw-bold fs-1">{{ $engineData->name }}</span>
                        </div>
                        <span class="fw-bold fs-1 text-red-600">- {{ Helpers::eur($amountGlobal) }}</span>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" x-on:click="card_checkout = false; card_config = true;" class="btn btn-lg btn-outline btn-outline-secondary">
                            <i class="fa-solid fa-arrow-alt-circle-left me-3"></i>
                            <span>Précédent</span>
                        </button>
                        <button type="submit" class="btn btn-lg btn-outline btn-outline-success">
                            <i class="fa-solid fa-shopping-cart me-3"></i>
                            <span>Valider la location</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>

@push('scripts')
    <x-scripts.pluginForm />
@endpush
