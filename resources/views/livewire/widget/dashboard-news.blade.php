<div class="@if(count($articles) > 0) swiper @endif h-350px rounded-3" wire:loading.class="opacity-50 bg-grey-700" id="swiper-default">
    @if(count($articles) > 0)
    <div class="swiper-wrapper">
        @foreach($articles as $article)
        <div class="swiper-slide bgi-position-center bgi-size-contain" style="background: url('{{ $article->image }}')">
            <a href="" class="d-flex align-items-end h-100">
                <div class="d-flex flex-row justify-content-between align-items-center w-100  bg-gray-600 bg-opacity-50 text-dark p-5">
                    <div class="d-flex flex-column">
                        <span class="fw-bold fs-2">{{ $article->title }}</span>
                        <span class="text-muted">{{ Str::limit($article->description, 50) }}</span>
                    </div>
                    <span class="badge badge-lg badge-dark">{{ $article->published_at->format('d/m/Y') }}</span>
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
