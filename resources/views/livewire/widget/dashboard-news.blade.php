<div class="card shadow-sm">
    <div class="card-body h-325px scroll">
        @foreach($articles as $article)
            <a href="" class="d-flex flex-row justify-content-between align-items-center rounded-3 bg-gray-100 p-5 mb-2 text-black hover-scale">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-50px symbol-2by3 me-3">
                        <img src="{{ $article->image }}" alt="">
                    </div>
                    <div class="d-flex flex-column">
                        <span class="fw-bold">{{ $article->title }}</span>
                        <span class="text-muted fst-italic">{{ Str::limit($article->description, 50) }}</span>
                    </div>
                </div>
                <span class="badge badge-secondary">{{ $article->published_at->format('d/m/Y') }}</span>
            </a>
        @endforeach
    </div>
</div>
