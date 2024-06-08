@extends('layouts.app')

@section("title")
    Succès
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Succès'],
        "notitle" => true
    ])
@endsection

@section("content")
    <div id="kt_app_content" class="app-content h-500px rounded-3 d-flex flex-column justify-content-center align-items-center bg-trophy firefly">
        <div class="d-flex justify-content-evenly align-items-center w-100 mx-auto">
            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Core\AchievementTypeEnum::class)->toArray() as $sector)
                <a href="{{ route('trophy.show', $sector['value']) }}" class="d-flex flex-column justify-content-center animate__animated animate__slideInDown panelZoom">
                    <div class="symbol symbol-200px mb-2">
                        <img src="{{ Storage::url('icons/railway/success/'.$sector['value'].'.png') }}" alt="">
                    </div>
                    <span class="bg-gray-200 bg-opacity-20 rounded-2 p-5 text-center fs-2 fw-bold text-white">{{ $sector['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush

