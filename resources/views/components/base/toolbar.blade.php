<div id="kt_app_toolbar" class="app-toolbar py-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
        <!--begin::Toolbar container-->
        <div class="d-flex flex-column flex-row-fluid">
            <!--begin::Toolbar wrapper-->
            <div class="d-flex align-items-center pt-1">
                @isset($breads)
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-white fw-bold lh-1">
                        <a href="{{ route('home') }}" class="text-white">
                            <i class="ki-outline ki-home text-white fs-3"></i>
                        </a>
                    </li>
                    <!--end::Item-->
                    @foreach($breads as $bread)
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-4 text-white mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-white fw-bold lh-1">{{ $bread }}</li>
                        <!--end::Item-->
                    @endforeach

                </ul>
                <!--end::Breadcrumb-->
                @endisset
            </div>
            <!--end::Toolbar wrapper=-->
            <!--begin::Toolbar wrapper=-->
            <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-6 pb-18 py-lg-13">
                <!--begin::Page title-->
                <div class="page-title d-flex align-items-center me-3">
                    <img alt="Logo" src="{{ $user->socials()->first()->avatar }}" class="h-60px me-5" />
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-white fw-bolder fs-2 flex-column justify-content-center my-0">
                        {{ $user->railway->name_company }}
                        <!--begin::Description-->
                        <span class="page-desc text-white opacity-50 fs-6 fw-bold pt-4">{{ $user->railway->desc_company }}</span>
                        <!--end::Description--></h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Items-->
                <div class="d-flex gap-4 gap-lg-13">
                    <!--begin::Item-->
                    <div class="d-flex flex-column">
                        <!--begin::Number-->
                        <span class="text-white fw-bold fs-3 mb-1">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($user->railway->argent) }}</span>
                        <!--end::Number-->
                        <!--begin::Section-->
                        <div class="text-white opacity-50 fw-bold">Argent disponible</div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex flex-column">
                        <!--begin::Number-->
                        <span class="text-white fw-bold fs-3 mb-1">{{ $user->railway->tpoint }}</span>
                        <!--end::Number-->
                        <!--begin::Section-->
                        <div class="text-white opacity-50 fw-bold">Travel Point</div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex flex-column">
                        <!--begin::Number-->
                        <span class="text-white fw-bold fs-3 mb-1">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($user->railway->research) }}</span>
                        <!--end::Number-->
                        <!--begin::Section-->
                        <div class="text-white opacity-50 fw-bold">Allocation de recherche</div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                </div>
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-50px me-5">
                        <img src="{{ Storage::url('icons/railway/level-up.png') }}" alt="">
                    </div>
                    <div class="d-flex flex-column">
                        <span class="text-warning fs-2x fw-bold">Niveau {{ $user->railway->level }}</span>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <span class="text-white">{{ $user->railway->xp }} EXP</span>
                            <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $user->railway->xp_percent }}%;" aria-valuenow="{{ $user->railway->xp_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Items-->
            </div>
        </div>
        <!--end::Toolbar container=-->
    </div>
    <!--end::Toolbar container-->
</div>
