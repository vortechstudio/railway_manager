@extends('layouts.app')

@section("title")
    Mon Profil
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Compte', 'Mon Compte')" />
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content animated-background h-100">
            <div class="card shadow-sm bg-brown-800">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-5 mb-5">
                            <livewire:account.profil-card-user :user="$user" />
                        </div>
                        <div class="col-sm-12 col-lg-7 mb-5">
                            <livewire:account.profil-tab :user="$user" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

