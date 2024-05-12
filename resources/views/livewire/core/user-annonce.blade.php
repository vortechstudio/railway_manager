<div class="app-navbar-item ms-1 ms-lg-5">
    <!--begin::Menu- wrapper-->
    <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom">
        <i class="ki-outline ki-information fs-1"></i>
    </div>
    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
        <!--begin::Heading-->
        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('/media/misc/menu-header-bg.jpg')">
            <!--begin::Title-->
            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Annonces</h3>
            <!--end::Title-->
            <!--begin::Tabs-->
            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#news">Nouvelles & Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#updates">Mises à jours</a>
                </li>
            </ul>
            <!--end::Tabs-->
        </div>
        <!--end::Heading-->
        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab panel-->
            <div class="tab-pane fade show active" id="news" role="tabpanel">
                <!--begin::Items-->
                <div class="scroll-y mh-325px my-5 px-8">
                    <!--begin::Item-->
                    @foreach($news as $article)
                        <div class="d-flex flex-stack py-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-3">
                                    <img src="{{ $article->image }}" alt="">
                                </div>
                                <div class="mb-0 me-2">
                                    <a href="{{ $article->url }}" target="_blank" class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $article->title }}</a>
                                    <div class="text-gray-400 fs-7">{{ Str::limit($article->description, 50) }}</div>
                                </div>
                            </div>
                            <span class="badge badge-light fs-8">{{ $article->published_at->longAbsoluteDiffForHumans() }}</span>
                        </div>
                    @endforeach
                    <!--end::Item-->
                </div>
                <!--end::Items-->
                <!--begin::View more-->
                <div class="py-3 text-center border-top">
                    <a href="//{{ config('app.domain') }}/news/{{ $service->cercle_id }}" class="btn btn-color-gray-600 btn-active-color-primary">Voir toute les news
                        <i class="ki-outline ki-arrow-right fs-5"></i></a>
                </div>
                <!--end::View more-->
            </div>
            <div class="tab-pane fade" id="updates" role="tabpanel">
                <!--begin::Items-->
                <div class="scroll-y mh-325px my-5 px-8">
                    <!--begin::Item-->
                    @foreach($updates as $article)
                        <div class="d-flex flex-stack py-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-3">
                                    <img src="{{ $article->image }}" alt="">
                                </div>
                                <div class="mb-0 me-2">
                                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $article->title }}</a>
                                    <div class="text-gray-400 fs-7">{{ Str::limit($article->description, 50) }}</div>
                                </div>
                            </div>
                            <span class="badge badge-light fs-8">{{ $article->published_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                    <!--end::Item-->
                </div>
                <!--end::Items-->
                <!--begin::View more-->
                <div class="py-3 text-center border-top">
                    <a href="../../demo30/dist/pages/user-profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">View All
                        <i class="ki-outline ki-arrow-right fs-5"></i></a>
                </div>
                <!--end::View more-->
            </div>
            <!--end::Tab panel-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::Menu-->
    <!--end::Menu wrapper-->
</div>
