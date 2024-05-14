<!--begin::Header-->
<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
        <!--begin::Header mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-color-gray-600 btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
        </div>
        <!--end::Header mobile toggle-->
        <!--begin::Logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
            <a href="{{ route('home') }}">
                <img alt="Logo" src="{{ Storage::url("services/$service->id/logo-seul.png") }}" class="h-25px d-lg-none" />
                <img alt="Logo" src="{{ Storage::url("services/$service->id/logo.png") }}" class="h-25px d-none d-lg-inline app-sidebar-logo-default theme-light-show" />
                <img alt="Logo" src="{{ Storage::url("services/$service->id/logo-long-white.png") }}" class="h-25px d-none d-lg-inline app-sidebar-logo-default theme-dark-show" />
            </a>
        </div>
        <!--end::Logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->
                <div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
                    @foreach(\App\Models\Config\Menu::section('railway_manager_app')->get() as $menu)
                        @if($menu->children->isNotEmpty())
                            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" data-kt-menu-offset="-50,0" class="menu-item {{ Request::is($menu->url) ? 'here show' : '' }} menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                                <span class="menu-link">
                                    @if($menu->icon)
                                        <span class="menu-icon">
                                            <i class="{{ $menu->icon }} fs-2"></i>
                                        </span>
                                    @endif
									<span class="menu-title">{{ $menu->translations()->first()->title }}</span>
									<span class="menu-arrow d-lg-none"></span>
								</span>
                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
                                    @foreach($menu->children as $child)
                                    <div class="menu-item {{ Request::is($menu->url) ? 'here show' : '' }}">
                                        <a class="menu-link" href="{{ $child->url }}" title="{{ $child->translations()->first()->title }}">
                                            <span class="menu-title">{{ $child->translations()->first()->title }}</span>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="menu-item {{ Request::is($menu->url) ? 'here show' : '' }}">
                                <a class="menu-link" href="{{ $menu->url }}" title="{{ $menu->translations()->first()->title }}">
                                    @if($menu->icon)
                                        <span class="menu-icon">
                                            <i class="{{ $menu->icon }} fs-2"></i>
                                        </span>
                                    @endif
                                    <span class="menu-title">{{ $menu->translations()->first()->title }}</span>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::Notifications-->
                <livewire:core.user-annonce />
                <!--end::Notifications-->
                @if($user->unreadNotifications()->count() > 0)
                <livewire:core.user-notification />
                @endif
                <!--begin::Chat-->
                <div class="app-navbar-item ms-1 ms-lg-5">
                    <!--begin::Menu wrapper-->
                    <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative" id="kt_drawer_chat_toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Communiquer avec votre conseiller">
                        <i class="ki-outline ki-messages fs-1"></i>
                    </div>
                    <!--end::Menu wrapper-->
                </div>
                <!--end::Chat-->
                <!--begin::User menu-->
                <livewire:core.user-bar />
                <!--end::User menu-->
                <!--begin::Header menu toggle-->
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
<!--end::Header-->
