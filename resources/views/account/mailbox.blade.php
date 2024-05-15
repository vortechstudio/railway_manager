@extends('layouts.app')

@section("title")
    Messagerie
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Compte', 'Messagerie')" />
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content h-100">
            <ul class="d-flex flex-row justify-content-center gap-5 mb-5 nav nav-tabs" role="tablist">
                @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\MessageTypeEnum::class)->toArray() as $k => $type)
                    <li class="nav-item ">
                        <a href="#{{ $type['value'] }}" class="nav-link {{ $k == 0 ? 'active' : '' }} rounded-circle p-5 border-active-primary" data-bs-toggle="tab">
                    <span class="symbol symbol-circle symbol-70px">
                        @if($type['value'] == 'global')
                            <i class="fa-solid fa-globe fs-5tx text-active-primary"></i>
                        @elseif($type['value'] == 'account')
                            <i class="fa-solid fa-user-circle fs-5tx text-active-primary"></i>
                        @endif
                    </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="myTabContent">
                @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\MessageTypeEnum::class)->toArray() as $k => $type)
                    <div class="tab-pane fade {{ $k == 0 ? 'show active' : '' }}" id="{{ $type['value'] }}" role="tabpanel">
                        <livewire:account.mailboxes :type="$type['value']" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

