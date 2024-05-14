<div>
    <div class="card shadow-sm rounded-3 animate__animated animate__fadeInRight">
        <div class="card-body">
            <div class="d-flex flex-column bg-brown-400 align-items-center rounded-top-2 z-index-2 p-5">
                <button class="btn btn-icon btn-circle btn-sm btn-outline btn-outline-dark position-absolute top-0 end-0 m-5 rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="fa-solid fa-ellipsis-h"></i>
                </button>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true">
                    <div class="menu-item px-3">
                        <a href="#editSign" data-bs-toggle="modal" class="menu-link px-3">
                            Modifier la signature
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#editBirthday" data-bs-toggle="modal" class="menu-link px-3">
                            Date d'anniversaire
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#editSocials" data-bs-toggle="modal" class="menu-link px-3">
                            Paramètres sociaux
                        </a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#claimVourcher" data-bs-toggle="tooltip" data-bs-title="Bientôt disponible" class="menu-link px-3" disabled="true">
                            Code d'échange
                        </a>
                    </div>
                </div>
                <div class="symbol symbol-circle symbol-80px">
                    <img src="{{ $user->socials()->first()->avatar }}" alt="">
                    @if($user->services()->where('service_id', $service->id)->first()->premium)
                        <span class="symbol-badge badge badge-circle bg-light start-100 animate__animated animate__bounceIn animate__delay-2s">
                        <img src="{{ Storage::url('icons/railway/premium.png') }}" class="w-15px" alt="">
                    </span>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <span class="fs-2 fw-bold me-2">{{ $user->name }}</span>
                    <a data-bs-toggle="modal" href="#editName" class="btn btn-sm btn-circle btn-icon btn-light"><i class="fa-solid fa-pencil"></i> </a>
                </div>
            </div>
            <div class="d-flex flex-column bg-white align-items-center rounded-bottom-2 p-5">
                <div class="d-flex flex-row justify-content-around align-items-center gap-3 mb-2">
                    <div class="d-flex flex-column align-items-center p-5 rounded-3 border border-primary animate__animated animate__bounceIn animate__delay-2s">
                        <div class="symbol symbol-75px">
                            <img src="{{ Storage::url('icons/railway/level-up.png') }}" alt="">
                        </div>
                        <span class="text-gray-300 fw-bold fs-1">{{ $user->railway->level }}</span>
                    </div>
                    <div class="d-flex flex-column align-items-center p-5 rounded-3 border border-primary animate__animated animate__bounceIn animate__delay-3s">
                        <div class="symbol symbol-75px">
                            <img src="{{ Storage::url('icons/railway/experience.png') }}" alt="">
                        </div>
                        <span class="text-gray-300 fw-bold fs-1">{{ $user->railway->xp }}</span>
                    </div>
                    <div class="d-flex flex-column align-items-center p-5 rounded-3 border border-primary animate__animated animate__bounceIn animate__delay-4s">
                        <div class="symbol symbol-75px">
                            <img src="{{ Storage::url('icons/railway/ranking.png') }}" alt="">
                        </div>
                        <span class="text-gray-300 fw-bold fs-1">{{ $user->railway->ranking }}</span>
                    </div>
                </div>
                <div class="d-flex rounded-bottom-3 bg-grey-200 h-150px p-5 w-100 text-dark animate__animated animate__fadeInRight animate__delay-5s">
                    {!! $user->profil->signature ?? 'Aucune signature' !!}
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="editName">
        <form action="" wire:submit="saveName" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Modifier votre nom</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.input
                            name="name"
                            value="{{ $user->name }}"
                            no-label="true"
                            required="true"
                            hint="Vous ne pouvez pas modifier votre nom au cours de 72 heures suivant la dernière modification" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="resetForm">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="saveName"><i class="fa-solid fa-check-circle me-3"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveName"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="editSign">
        <form action="" wire:submit="saveSign" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Modifier votre signature</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.textarea
                            name="signature"
                            value="{{ $user->profil->signature }}"
                            label="Signature"
                            required="true" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="resetForm">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="saveName"><i class="fa-solid fa-check-circle me-3"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveName"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="editSocials">
        <form action="" wire:submit="saveSocial" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Paramètre social</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center rounded-top-2 p-3 bg-grey-300">
                            <span>Accepter automatiquement les demandes d'amis</span>
                            <x-form.switches
                                name="accept_friends"
                                :checked="$accept_friends"
                                label=""
                                value="1" />
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 bg-grey-400">
                            <span>Rendre votre registre de gestion public</span>
                            <x-form.switches
                                name="display_registry"
                                :checked="$display_registry"
                                label=""
                                value="1" />
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 bg-grey-300">
                            <span>Rendre votre status de connexion public</span>
                            <x-form.switches
                                name="display_online_status"
                                :checked="$display_online_status"
                                label=""
                                value="1" />
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 bg-grey-400">
                            <span>
                                Accepter de recevoir des notifications
                                <i class="fa-solid fa-info-circle" data-bs-toggle="tooltip" data-bs-title="Vous devez également accepter de recevoir les notifications par le navigateur"></i>
                            </span>
                            <x-form.switches
                                name="accept_notification"
                                :checked="$accept_notification"
                                label=""
                                value="1" />
                        </div>
                        <div class="d-flex justify-content-between align-items-center rounded-bottom-2 p-3 bg-grey-300">
                            <span>
                                Accepter de recevoir des newsletter periodique
                                <i class="fa-solid fa-info-circle" data-bs-toggle="tooltip" data-bs-title="Les newsletters sont envoyer à interval de plus ou moins 1 mois"></i>
                            </span>
                            <x-form.switches
                                name="accept_newsletter"
                                :checked="$accept_newsletter"
                                label=""
                                value="1" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="resetForm">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="saveName"><i class="fa-solid fa-check-circle me-3"></i> Enregistrer</span>
                            <span wire:loading wire:target="saveName"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="claimVourcher">
        <form action="" wire:submit="claim" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Code d'échange</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.input
                            name="code"
                            no-label="true"
                            placeholder="Veuillez saisir le code d'échange"
                            required="true" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa-solid fa-xmark-circle me-3"></i> Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="saveName"><i class="fa-solid fa-check-circle me-3"></i> Confirmer</span>
                            <span wire:loading wire:target="saveName"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="editBirthday">
        <form action="" wire:submit="birthday" method="POST">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Date d'anniversaire</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <x-form.input
                            type="date"
                            name="birthday"
                            no-label="true"
                            placeholder="Veuillez saisir le votre date d'anniversaire"
                            required="true" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa-solid fa-xmark-circle me-3"></i> Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="birthday"><i class="fa-solid fa-check-circle me-3"></i> Confirmer</span>
                            <span wire:loading wire:target="birthday"><i class="fa-solid fa-spinner fa-spin-pulse"></i>Veuillez patienter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <x-base.close-modal />
@endpush
