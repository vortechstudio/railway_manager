<div class="app-content bg-brown-400">
    <div class="d-flex flex-column justify-content-center align-items-center gap-5">
        <ul class="nav nav-pills nav-pills-custom" role="tablist">
            <li class="nav-item mb-3 me-3 me-lg-5" role="presentation">
                <a class="nav-link text-gray-400 text-hover-warning text-active-warning rounded-0 border-active border-bottom-4 border-top-0 border-right-0 border-left-0 border-active border-active-warning active" href="#informations" data-bs-toggle="pill" role="tab" aria-selected="false" tabindex="-1">
                    <span class="fs-1 fw-semibold">Information</span>
                </a>
            </li>
            <li class="nav-item mb-3 me-3 me-lg-5" role="presentation">
                <a class="nav-link text-gray-400 text-hover-warning text-active-warning rounded-0 border-active border-bottom-4 border-top-0 border-right-0 border-left-0 border-active border-active-warning " href="#annonces" data-bs-toggle="pill" role="tab" aria-selected="false" tabindex="-1">
                    <span class="fs-1 fw-semibold">Annonces</span>
                </a>
            </li>
        </ul>
        <div class="bg-white p-15 w-100 rounded">
            <div class="tab-content">
                <div class="tab-pane fade active show" id="informations" role="tabpanel" aria-labelledby="informations">
                    <div class="row">
                        <div class="col-6 h-100 align-items-center">
                            @isset($article_promote)
                                <a href="{{ $article_promote->url }}">
                                    <img src="{{ $article_promote->image }}" class="img-thumbnail" alt="">
                                </a>
                            @else
                                <x-base.is-null
                                    text="Aucune promotion en cours..." />
                            @endisset
                        </div>
                        <div class="col-6 h-100 hover-scroll-y">
                            <div class="d-flex flex-column">
                                @if(count($articles) > 0)
                                    @foreach($articles as $article)
                                        <a href="{{ $article->url }}">
                                            <img src="{{ $article->image_head }}" class="img-thumbnail rounded-2" alt="">
                                        </a>
                                    @endforeach
                                @else
                                    <x-base.is-null
                                        text="Aucune nouvelle actuellement" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="annonces" role="tabpanel" aria-labelledby="annonces">
                    <div class="row">
                        <div class="col-md-4 h-450px hover-scroll-y">
                            <ul class="nav nav-pills nav-pills-custom" role="tablist">
                                @foreach($notices as $notice)
                                    <li class="nav-item w-100">
                                        <a wire:click.prevent="read({{ $notice->id }})" class="d-flex btn btn-flex btn-outline btn-color-muted btn-active-color-warning btn-active-gray flex-row overflow-hidden h-100px showNotice" data-article-id="{{ $notice->id }}" href="#notice_{{ $notice->id }}" data-bs-toggle="pill" role="tab">
                                            <span class="noticeUnread"></span>
                                            <span class="fs-3 fs-3">{{ $notice->title }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-8 h-450px">
                            <div class="tab-content">
                                @foreach($notices as $notice)
                                    <div class="tab-pane fade {{ $selectedNotice == $notice->id ? 'active show' : '' }}" id="notice_{{ $notice->id }}" role="tabpanel">
                                        <div class="d-flex flex-column h-450px hover-scroll-y">
                                            <span class="fs-1 fw-bold">{{ $notice->title }}</span>
                                            <div class="separator border-dotted mb-5"></div>
                                            <img src="{{ $notice->image_head }}" class="img-thumbnail mb-3" alt="">
                                            <span class="mb-3">{!! $notice->description !!}</span>
                                            {!! $notice->contenue !!}

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.onload = markAllAsRead;
    </script>
@endpush
