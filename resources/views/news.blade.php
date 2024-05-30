@extends('layouts.app')

@section("title")
    Nouvelle en provenance des rails
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Nouvelle en provenance des rails'],
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <livewire:core.news-panel />
    </div>
@endsection

