<div class="@if(count($articles) > 0) swiper @endif h-350px rounded-3" wire:loading.class="opacity-50 bg-grey-700" id="swiper-default">
    @if(count($articles) > 0)
    <div class="swiper-wrapper">
        @foreach($articles as $article)
        <div class="swiper-slide bg-gradient ">
            <a href="" class="d-flex align-items-end h-100">
                <div class="d-flex flex-row justify-content-between align-items-center w-100  bg-gray-400 bg-opacity-25 p-5">
                    <div class="d-flex flex-column">
                        <span class="fw-bold fs-2">Version 0.5.1 disponible !</span>
                        <span class="text-muted">Lorem Ispum</span>
                    </div>
                    <span class="badge badge-lg badge-dark">11/05/2024</span>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
    @else
    <x-base.is-null
        text="Aucune news actuellement !" />
    @endif
</div>
