@extends('layouts.app')

@section("title")
    Boutique
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Boutique')"
        notitle="true" />
@endsection

@section("content")
    <div id="kt_app_content" class="app-content rounded-3 animated-background">
        <livewire:shop.toolbar />
        <div class="separator border border-2 rounded-3 mb-5"></div>
        <livewire:shop.content />
    </div>
@endsection

