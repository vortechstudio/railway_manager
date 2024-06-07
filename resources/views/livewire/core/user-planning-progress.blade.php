@if(count($plannings) >= 0)
    <div class="app-navbar-item ms-1 ms-lg-5" wire:poll.visible>
        <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative pulse pulse-danger" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom">
            <i class="ki-duotone ki-route fs-1">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
                <span class="path4"></span>
            </i>
            <span class="pulse-ring"></span>
        </div>
        <div class="menu menu-sub menu-sub-dropdown menu-column w-700px w-sm-500px" data-kt-menu="true" style="">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">Trajets en cours</div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-5">
                    <!--begin::Scroll-->
                    <div class="mh-450px scroll-y ">
                        @foreach($plannings as $planning)
                            <a href="{{ route('network.travel.show', $planning->id) }}" class="card shadow-sm mb-2 mx-0 text-black">
                                <div class="card-body bg-blue-200">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-40px me-2">
                                                <i class="fa-solid fa-circle fs-1 text-red-400"></i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">{{ $planning->userRailwayLigne->railwayLigne->name }}</span>
                                                <span>
                                                    <strong>Prochain arret:</strong>
                                                    @if($planning->stations()->where('status', 'init')->first())
                                                    {{ $planning->stations()->where('status', 'init')->first()->railwayLigneStation->gare->name }}
                                                    @else
                                                    {{ $planning->userRailwayLigne->railwayLigne->end->name }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <span class="badge badge-secondary">Arrivée {{ $planning->date_arrived->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
@else
    <div></div>
@endif
