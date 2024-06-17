@extends('layouts.app')

@section("title")
    Services
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Services'],
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <div class="d-flex justify-content-center align-items-center gap-5">
                <a href="{{ route('account.leveling') }}" class="card shadow-sm hover-scale animated-background h-150px">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center align-items-center mx-auto">
                            <img src="{{ Storage::url('icons/railway/level-up.png') }}" class="h-125px img-fluid" alt="">
                        </div>
                    </div>
                </a>
                <a href="{{ route('trophy.index') }}" class="card shadow-sm hover-scale animated-background h-150px">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center align-items-center mx-auto">
                            <img src="{{ Storage::url('icons/railway/trophy.png') }}" class="h-125px img-fluid" alt="">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush

