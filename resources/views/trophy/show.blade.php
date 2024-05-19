@extends('layouts.app')

@section("title")
    {{ $sector }}
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Succès', $sector)"
        notitle="true" />
@endsection

@section("content")

    <div id="kt_app_content" class="app-content h-sm-100 h-lg-700px rounded-3 d-flex flex-column flex-lg-row justify-content-center align-items-center bg-trophy firefly">
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-200px mb-7 me-lg-10">
            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\AchievementSectorEnum::class)->toArray() as $type)
                <a href="{{ route('trophy.show', $type['value']) }}" class="{{ $type['value'] == $sector ? '' : 'hover-scale' }} mb-5">
                    <span class="symbol symbol-sm-60px symbol-lg-150px symbol-circle bg-gray-300 bg-opacity-25 bg-active-primary bg-active-opacity-100 {{ $type['value'] == $sector ? 'active scale-up' : '' }}">
                        <img src="{{ Storage::url('icons/railway/success/'.$type['value'].'.png') }}" alt="">
                    </span>
                </a>
            @endforeach
        </div>
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <livewire:shop.toolbar :no-text="false" />
            <livewire:trophy.trophy-panel :sector="$sector" />
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush

