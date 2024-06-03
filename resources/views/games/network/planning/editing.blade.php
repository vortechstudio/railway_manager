@extends('layouts.app')

@section("title")
    Edition du planning
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Réseau Ferroviaire', 'Planification', 'Edition du planning'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.network-menu />
            <div class="row">
                <div class="col-sm-12 col-lg-10 mb-3">
                    @if(auth()->user()->railway->automated_planning)
                        <x-base.alert
                            type="info"
                            icon="fa-solid fa-question-circle"
                            title="Planification automatique"
                            content="La planification automatique permet de planifier automatiquement les trajets de vos lignes.<br>Vous ne pouvez donc pas modifier les trajets de vos lignes.<br>Si vous désactivez la planification automatique, vous pourrez modifier les trajets de vos lignes." />

                        @livewire('game.planning.planning-timeline')
                    @else
                        <div class="position-fixed bottom-0 end-0 p-3 z-index-3">
                            <div id="kt_docs_toast_toggle" class="toast show bg-light-primary" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                                <div class="toast-header bg-primary">
                                    <i class="ki-duotone ki-question fs-2 text-white me-3"><span class="path1"></span><span class="path2"></span></i>
                                    <strong class="me-auto">Aide disponible</strong>
                                    <small>&nbsp;</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    <p>Un tutoriel est disponible pour cette page</p>
                                    <a href="" class="btn btn-sm btn-secondary">Cliquez ici</a>
                                </div>
                            </div>
                        </div>

                        @livewire('game.planning.planning-manual')

                    @endif
                </div>
                <div class="col-sm-12 col-lg-2 mb-3">
                    @livewire('game.planning.planning-automated')
                </div>
            </div>
        </div>
    </div>
@endsection

