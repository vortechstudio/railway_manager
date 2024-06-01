<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
            <div class="card-toolbar">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newPlanning">Nouvelle planification</button>
            </div>
        </div>
        <div class="card-body">
            <div class="rounded-2 table-responsive">
                <table class="table table-striped table-bordered table-dark g-7 align-middle">
                    <thead>
                    <tr>
                        <th>Matériel</th>
                        @for($i=1; $i <= 7; $i++)
                            <th>{{ now()->locale('fr_FR')->startOfWeek(\Carbon\Carbon::SUNDAY)->addDays($i)->dayName }}</th>
                        @endfor
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($engines as $engine)
                        @if($engine->userRailwayLigne()->exists())
                            <tr>
                                <td>{{ $engine->railwayEngine->name }}</td>
                                @for($i=1; $i <= 7; $i++)
                                    <td>
                                        @isset($engine->constructors)
                                            @foreach($engine->constructors as $planning)
                                                @if(in_array($i, json_decode($planning->day_of_week)))
                                                    <span class="badge badge-sm bg-color-{{ $engine->railwayEngine->type_transport->value }} text-white">{{ $planning->start_at->format("H:i") }} - {{ $planning->end_at->format("H:i") }} | {{ $engine->userRailwayLigne->railwayLigne->name}}</span>
                                                @endif
                                            @endforeach
                                        @endisset
                                    </td>
                                @endfor
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="newPlanning">
        <form action="" wire:submit="save">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouvelle planification</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="mb-10" wire:ignore>
                            <label for="user_railway_engine_id" class="form-label required">Rame</label>
                            <select wire:model="user_railway_engine_id" name="user_railway_engine_id" id="user_railway_engine_id" class="form-select" data-control="select2" data-placeholder="---  Selectionner un type de matériel ---" required>
                                <option></option>
                                @foreach($engines as $engine)
                                    <option value="{{ $engine->id }}">{{ $engine->number }} / {{ $engine->railwayEngine->name }} / {{ $engine->userRailwayLigne->railwayLigne->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form.input
                            name="date_depart"
                            label="Heure de départ"
                            required="true"
                            control="time" />

                        <div class="d-flex flex-row justify-content-around align-items-center mb-10">
                            <label for="" class="form-label">Jour du planning</label>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="day" name="day[]" type="checkbox" value="1" id="lundi">
                                <label class="form-check-label" for="lundi">
                                    Lundi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="day" name="day[]" type="checkbox" value="2" id="mardi">
                                <label class="form-check-label" for="mardi">
                                    Mardi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="day" name="day[]" type="checkbox" value="3" id="mercredi">
                                <label class="form-check-label" for="mercredi">
                                    Mercredi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="day" name="day[]" type="checkbox" value="4" id="jeudi">
                                <label class="form-check-label" for="jeudi">
                                    Jeudi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="day" name="day[]" type="checkbox" value="5" id="vendredi">
                                <label class="form-check-label" for="vendredi">
                                    Vendredi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="day" name="day[]" type="checkbox" value="6" id="samedi">
                                <label class="form-check-label" for="samedi">
                                    Samedi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="day" name="day[]" type="checkbox" value="7" id="dimanche">
                                <label class="form-check-label" for="dimanche">
                                    Dimanche
                                </label>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-around align-items-center mb-10">
                            <div class="d-flex flex-column justify-content-center">
                                <label for="" class="form-label">Répétition</label>
                                <div class="form-floating mb-7">
                                    <input type="number" class="form-control" wire:model="number_repeat" name="number_repeat" id="number_repeat" value="1"/>
                                    <label for="floatingInput">Nombre de répétition</label>
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" wire:model="repeat" name="repeat" type="radio" value="hebdo" id="hebdo">
                                <label class="form-check-label" for="hebdo">
                                    Hebdomadaire
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="repeat" name="repeat" type="radio" value="mensuel" id="mensuel">
                                <label class="form-check-label" for="mensuel">
                                    Mensuel
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="repeat" name="repeat" type="radio" value="trim" id="trim">
                                <label class="form-check-label" for="trim">
                                    Trimestriel
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="repeat" name="repeat" type="radio" value="sem" id="sem">
                                <label class="form-check-label" for="sem">
                                    Semestriel
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="repeat" name="repeat" type="radio" value="annual" id="annual">
                                <label class="form-check-label" for="annual">
                                    Annuel
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermé</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                            <span wire:loading.remove wire:target="save">Valider</span>
                            <span wire:loading wire:target="save"><i class="fa-solid fa-spinner fa-spin me-2"></i> Veuillez patienter...</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <x-scripts.pluginForm />
</div>

@push('scripts')
    <x-base.close-modal />
@endpush
