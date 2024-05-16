@extends('layouts.app')

@section("title")
    Nouvelle en provenance des rails
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Nouvelle en provenance des rails')" />
@endsection

@section("content")
    <div class="container-xxl">
        <livewire:core.news-panel />
    </div>
@endsection

