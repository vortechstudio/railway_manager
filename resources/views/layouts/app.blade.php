<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.1.8
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->
<head><base href=""/>
    <title>@yield("title", "Page") - {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <link defer href="{{ asset('/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link defer href="{{ asset('/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @livewireStyles
    @vite(['resources/css/app.css'])
    @yield("styles")
    @stack("styles")
    @laravelPWA
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" class="app-default">
<!--begin::Theme mode setup on page load-->
<script>
    let defaultThemeMode = "light";
    let themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>
<!--end::Theme mode setup on page load-->
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        @include('layouts.includes.header')
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
                    <!--begin::Toolbar container-->
                    <div class="d-flex flex-column flex-row-fluid">
                        <!--begin::Toolbar wrapper-->
                        <div class="d-flex align-items-center pt-1">
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-white fw-bold lh-1">
                                    <a href="../../demo30/dist/index.html" class="text-white">
                                        <i class="ki-outline ki-home text-white fs-3"></i>
                                    </a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <i class="ki-outline ki-right fs-4 text-white mx-n1"></i>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-white fw-bold lh-1">Dashboards</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Toolbar wrapper=-->
                        <!--begin::Toolbar wrapper=-->
                        <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-6 pb-18 py-lg-13">
                            <!--begin::Page title-->
                            <div class="page-title d-flex align-items-center me-3">
                                <img alt="Logo" src="assets/media/svg/misc/layer.svg" class="h-60px me-5" />
                                <!--begin::Title-->
                                <h1 class="page-heading d-flex text-white fw-bolder fs-2 flex-column justify-content-center my-0">Chartmix - Finance Team
                                    <!--begin::Description-->
                                    <span class="page-desc text-white opacity-50 fs-6 fw-bold pt-4">Power Elite Seller</span>
                                    <!--end::Description--></h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Items-->
                            <div class="d-flex gap-4 gap-lg-13">
                                <!--begin::Item-->
                                <div class="d-flex flex-column">
                                    <!--begin::Number-->
                                    <span class="text-white fw-bold fs-3 mb-1">$23,467.92</span>
                                    <!--end::Number-->
                                    <!--begin::Section-->
                                    <div class="text-white opacity-50 fw-bold">Avg. Monthly Sales</div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-column">
                                    <!--begin::Number-->
                                    <span class="text-white fw-bold fs-3 mb-1">$1,748.03</span>
                                    <!--end::Number-->
                                    <!--begin::Section-->
                                    <div class="text-white opacity-50 fw-bold">Today Spending</div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-column">
                                    <!--begin::Number-->
                                    <span class="text-white fw-bold fs-3 mb-1">3.8%</span>
                                    <!--end::Number-->
                                    <!--begin::Section-->
                                    <div class="text-white opacity-50 fw-bold">Overall Share</div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-column">
                                    <!--begin::Number-->
                                    <span class="text-white fw-bold fs-3 mb-1">-7.4%</span>
                                    <!--end::Number-->
                                    <!--begin::Section-->
                                    <div class="text-white opacity-50 fw-bold">7 Days</div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Toolbar wrapper=-->
                    </div>
                    <!--end::Toolbar container=-->
                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Wrapper container-->
            <div class="app-container container-xxl">
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Content-->
                        @yield('content')
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    <div id="kt_app_footer" class="app-footer d-flex flex-column flex-md-row align-items-center flex-center flex-md-stack py-2 py-lg-4">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-semibold me-1">2023&copy;</span>
                            <a href="https://{{ config('app.domain') }}" target="_blank" class="text-gray-800 text-hover-primary">Railway Manager By Vortech Studio</a>
                        </div>
                        <!--end::Copyright-->
                        <!--begin::Menu-->
                        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                            <li class="menu-item">
                                <a href="//{{ config('app.game_url') }}" class="menu-link px-2" target="_blank">Site Web</a>
                            </li>
                            <li class="menu-item">
                                <a href="//status.{{ config('app.game_url') }}/status/vstudio" class="menu-link px-2" target="_blank">Status</a>
                            </li>
                            <li class="menu-item">
                                <a href="//{{ config('app.game_url') }}/version/latest" class="menu-link px-2" target="_blank">Note de version</a>
                            </li>
                            <li class="menu-item">
                                <a href="//{{ config('app.game_url') }}/roadmap" class="menu-link px-2" target="_blank">Roadmap</a>
                            </li>
                            <li class="menu-item">
                                <a href="//support.{{ config('app.domain') }}" class="menu-link px-2" target="_blank">Support</a>
                            </li>
                        </ul>
                        <!--end::Menu-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper container-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<livewire:core.user-chat-assistant />
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-outline ki-arrow-up"></i>
</div>
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/js/scripts.bundle.js') }}"></script>
@livewireScripts
@vite(['resources/js/app.js'])
<x-livewire-alert::scripts />
@yield("scripts")
@stack("scripts")
<!--end::Global Javascript Bundle-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
