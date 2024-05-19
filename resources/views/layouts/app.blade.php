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
    @vite(['resources/css/app.css', 'resources/sass/animate.scss'])
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
            @yield('toolbar')
            <!--end::Toolbar-->
            <!--begin::Wrapper container-->
            <div class="app-container container-fluid">
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
<livewire:core.modal-reward />
<script>var hostUrl = "assets/";</script>
@livewireScriptConfig
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/js/scripts.bundle.js') }}"></script>
@vite(['resources/js/app.js'])
<x-livewire-alert::scripts />
@yield("scripts")
@stack("scripts")
<!--end::Global Javascript Bundle-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
