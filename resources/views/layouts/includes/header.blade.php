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
                <div class="app-navbar-item ms-3 ms-lg-5" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px symbol-md-45px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img class="symbol symbol-circle symbol-35px symbol-md-45px" src="{{ $user->socials()->first()->avatar }}" alt="user" />
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{ $user->socials()->first()->avatar }}" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">{{ $user->name }}
                                        @if($user->services()->where('service_id', $service->id)->first()->premium)
                                            <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"><i class="ki-duotune ki-ranking"></i> Premium</span>
                                        @endif
                                    </div>
                                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ $user->email }}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('account.profil') }}" class="menu-link px-5">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-user-circle fs-2"></i>
                                </span>
                                Mon Profil
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('account.mailbox.inbox') }}" class="menu-link px-5">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-envelope fs-2"></i>
                                </span>
                                Ma messagerie
                            </a>
                        </div>
                        <div class="menu-item px-5">
                            <a href="{{ route('shop') }}" class="menu-link px-5">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-shopping-cart fs-2"></i>
                                </span>
                                Boutique
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                            <a href="#" class="menu-link px-5">
												<span class="menu-title position-relative">Mode
												<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
													<i class="ki-outline ki-night-day theme-light-show fs-2"></i>
													<i class="ki-outline ki-moon theme-dark-show fs-2"></i>
												</span></span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-night-day fs-2"></i>
														</span>
                                        <span class="menu-title">Light</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-moon fs-2"></i>
														</span>
                                        <span class="menu-title">Dark</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-screen fs-2"></i>
														</span>
                                        <span class="menu-title">System</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('auth.logout') }}" class="menu-link px-5">Déconnexion</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
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
