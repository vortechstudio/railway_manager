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
    <div id="kt_app_content" class="app-content">

    </div>
@endsection

