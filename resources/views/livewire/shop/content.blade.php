<div class="row">
    <div class="col-sm-12 col-lg-4 mb-5 h-700px rounded-3 bg-gray-100 bg-opacity-15">
        <ul class="d-flex flex-column h-100 nav nav-tabs hover-scroll-y">
            @foreach($shop->railway_categories as $category)
                <li class="nav-item w-100">
                    <a wire:click.prevent="selectCategory({{ $category->id }})" href="#items_{{ Str::snake($category->name) }}" class="nav-link min-h-150px p-5 bg-active-dark bg-active-opacity-100 bg-dark bg-opacity-10 {{ $shop_category_id == $category->id ? 'active' : '' }}" data-bs-toggle="tab">
                        <span class="d-flex align-items-center">
                            <span class="symbol symbol-circle symbol-100px me-5">
                                <img src="{{ $category->image }}" alt="">
                            </span>
                            <span class="text-white fw-bold fs-2tx">{{ $category->name }}</span>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-sm-12 col-lg-8 mb-5 h-700px">
        <div class="tab-content">
            @foreach($shop->railway_categories as $category)
                <div class="tab-pane fade {{ $shop_category_id == $category->id ? 'show active' : '' }}" id="items_{{ Str::snake($category->name) }}" role="tabpanel">
                    <div class="h-100 w-100 hover-scroll-y hover-scroll-x">
                        <div class="row">
                            @foreach($category->railway_items as $item)
                                <div class="col-4 mb-5">
                                    <a wire:click.prevent="checkout({{ $item->id }})" href="" class="card shadow-sm shop-bg-{{ $item->rarity }} bg-hover-opacity-50 ribbon ribbon-top-end">
                                        <div class="d-flex justify-content-center p-5">
                                            <span class="fw-bold fs-1">{{ Str::upper($item->name ) }}</span>
                                            @if($item->disponibility_end_at)
                                                <div class="ribbon-label bg-primary">{{ $item->disponibility_end_at->shortAbsoluteDiffForHumans() }}</div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center align-items-center h-250px">
                                            <img src="{{ $item->image }}" class="w-100" alt="">
                                        </div>
                                        <div class="card-footer  p-2 border-top-3 border-white bg-gray-800 bg-opacity-75 shadow-lg">
                                            <div class="d-flex justify-content-center">
                                                <span class="fw-bold fs-1 text-white">{!! $item->price_format !!}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <livewire:shop.modal-checkout />
    <livewire:shop.modal-pass-checkout />
</div>
