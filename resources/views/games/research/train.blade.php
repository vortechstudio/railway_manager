@extends('layouts.app')

@section("title")
    Matériels
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Recherche & Développement', 'Matériels'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">

        </div>
    </div>
@endsection

@push('scripts')

@endpush

