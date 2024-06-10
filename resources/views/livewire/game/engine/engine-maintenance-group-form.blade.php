<div wire:ignore.self class="modal fade" tabindex="-1" id="repair">
    <form action="" wire:submit="repair">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-amber-400 bg-striped">
                    <h3 class="modal-title">Maintenance</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="d-flex align-items-center gap-5 mb-10">
                        <div>
                            <input type="radio" wire:model.live="type" class="btn-check" name="type" value="engine_prev" id="engine_prev"/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="engine_prev">
                                <i class="fa-solid fa-clock fs-4x me-4"></i>

                                <span class="d-block fw-semibold text-start">
                                    <span class="text-gray-900 fw-bold d-block fs-3">Maintenance préventive</span>
                                    <span class="text-muted fw-semibold fs-6">
                                        Il s'agit d'une visite de la rame en technicentre permettant de déceler les éléments abîmés voire de les remplacer. Elle est peu coûteuse et remettra l’usure de la rame à 0 %, prévenant toutes pannes pour un certain temps.
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" wire:model.live="type" class="btn-check" name="type" value="engine_cur" id="engine_cur"/>
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="engine_cur">
                                <i class="fa-solid fa-cogs fs-4x me-4"></i>

                                <span class="d-block fw-semibold text-start">
                                    <span class="text-gray-900 fw-bold d-block fs-3">Maintenance Curative</span>
                                    <span class="text-muted fw-semibold fs-6">
                                        Ce type de maintenance consiste à démonter complètement la rame pour en observer et réparer en détail chaque partie puis à le remonter minutieusement. Ce processus est plus coûteux, mais permettra de remettre l’ancienneté de la rame à ⅕ ainsi que l’usure à 0%.
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mb-10">
                            <div class="card shadow-sm bg-blue-100 mb-5">
                                <div class="card-body">
                                    <span class="fs-2 fw-bold text-center">Usure de la rame</span>
                                    <div wire:ignore id="sliderUsure" class="mt-15" data-control="uiSlider" data-min="0" data-max="100" data-pan="1"></div>
                                </div>
                            </div>
                            <div class="card shadow-sm bg-blue-100">
                                <div class="card-body">
                                    <span class="fs-2 fw-bold text-center">Ancienneté de la rame</span>
                                    <div wire:ignore id="sliderAncien" class="mt-15" data-control="uiSlider" data-min="0" data-max="5" data-pan="1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6 mb-10">
                            <div class="bg-gray-800 rounded-3 p-5 text-white">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ Storage::url('icons/railway/train.png') }}" class="w-30px img-fluid me-3" alt="">
                                    <span class="fs-4 fw-semibold">Nombre de rame: {{ count($selectedEngines) }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ Storage::url('icons/railway/maintenance.png') }}" class="w-30px img-fluid me-3" alt="">
                                    <div class="d-flex flex-column">
                                        <div class="d-flex flex-row justify-content-between">
                                            <span class="me-10">Prix Préventif:</span>
                                            <span>{{ Helpers::eur($amount_prev) }}</span>
                                        </div>
                                        <div class="d-flex flex-row justify-content-between">
                                            <span class="me-10">Prix Curatif:</span>
                                            <span>{{ Helpers::eur($amount_cur) }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline btn-outline-primary" wire:loading.attr="disabled" wire:target="repair">
                        <span wire:loading.class="d-none" wire:target="repair">Lancer la maintenance</span>
                        <span class="d-none" wire:loading.class.remove="d-none" wire:target="repair">
                            <div class="spinner-grow me-2" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                            Chargement...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <x-scripts.pluginForm />
</div>


