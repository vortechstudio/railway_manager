<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @vite('resources/css/app.css')
    @laravelPWA
    @livewireStyles
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat" style="background: url('{{ Storage::url('services/2/wall_login.png') }}')">
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Aside-->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-lg-start flex-column">
                <!--begin::Logo-->
                <a href="{{ route('home') }}" class="mb-7">
                    <img alt="Logo" src="{{ Storage::url('services/2/logo-long-white.png') }}" />
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h2 class="text-white fw-normal m-0">Empowering Simulated World</h2>
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <!--begin::Card-->
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <!--begin::Wrapper-->
                <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="index.html" action="#">
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-gray-900 fw-bolder mb-3">Connexion à {{ config('app.name') }}</h1>
                            {!! \Vortechstudio\VersionBuildAction\Facades\VersionBuildAction::getLabelEnv() !!}
                            <!--end::Title-->

                        </div>
                        <!--begin::Heading-->
                        <!--begin::Login options-->
                        <div class="row g-3 mb-9">
                            <!--begin::Col-->
                            <div class="col-md-12">
                                <!--begin::Google link=-->
                                <a href="{{ route('auth.redirect', 'facebook') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo" src="{{ asset('/media/svg/brand-logos/facebook-1.svg') }}" class="h-15px me-3" />Connexion avec Facebook
                                </a>
                                <!--end::Google link=-->
                            </div>
                            <div class="col-md-12">
                                <!--begin::Google link=-->
                                <a href="{{ route('auth.redirect', 'google') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo" src="{{ asset('/media/svg/brand-logos/google-icon.svg') }}" class="h-15px me-3" />Connexion avec Google
                                </a>
                                <!--end::Google link=-->
                            </div>
                            <div class="col-md-12">
                                <!--begin::Google link=-->
                                <a href="{{ route('auth.redirect', 'steam') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo" src="{{ asset('/media/svg/brand-logos/steam.png') }}" class="h-15px me-3" />Connexion avec Steam
                                </a>
                                <!--end::Google link=-->
                            </div>
                            <div class="col-md-12">
                                <!--begin::Google link=-->
                                <a href="{{ route('auth.redirect', 'battlenet') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo" src="{{ asset('/media/svg/brand-logos/battlenet.png') }}" class="h-15px me-3" />Connexion avec Battle net
                                </a>
                                <!--end::Google link=-->
                            </div>
                            <div class="col-md-12">
                                <!--begin::Google link=-->
                                <a href="{{ route('auth.redirect', 'discord') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo" src="{{ asset('/media/svg/brand-logos/discord.png') }}" class="h-15px me-3" />Connexion avec Discord
                                </a>
                                <!--end::Google link=-->
                            </div>
                            <div class="col-md-12">
                                <!--begin::Google link=-->
                                <a href="{{ route('auth.redirect', 'twitch') }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Logo" src="{{ asset('/media/svg/brand-logos/twitch.svg') }}" class="h-15px me-3" />Connexion avec Twitch
                                </a>
                                <!--end::Google link=-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Login options-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
                <!--begin::Footer-->
                <div class="d-flex flex-stack px-lg-10">
                    <!--begin::Languages-->
                    <div class="me-0">
                        <span>Version: {{ $version }}</span>
                    </div>
                    <!--end::Languages-->
                    <!--begin::Links-->
                    <div class="d-flex fw-semibold text-primary fs-base gap-5">
                        <a href="//{{ config('app.game_url') }}" target="_blank">Site Web</a>
                        <a href="//status.{{ config('app.game_url') }}/status/vstudio" target="_blank">Status</a>
                        <a href="//{{ config('app.game_url') }}/version/latest" target="_blank">Note de version</a>
                        <a href="//{{ config('app.game_url') }}/roadmap" target="_blank">Roadmap</a>
                        <a href="//support.{{ config('app.domain') }}" target="_blank">Support</a>
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/js/scripts.bundle.js') }}"></script>
@vite('resources/js/app.js')
@livewireScripts
</body>
</html>
