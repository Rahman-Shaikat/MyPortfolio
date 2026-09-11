<x-frontend::layout :profile="$profile" :seo="$seo">
    <article class="section-pad page-hero">
        <div class="container research-detail">
            <header class="section-heading reveal">
                <p class="eyebrow">Scholarly publication</p>
                <h1 class="page-title">{{ $publication->title }}</h1>
                @if ($publication->authors)
                    <p class="publication-authors">
                        @foreach ($publication->authors as $author)
                            @if ($author === config('seo.person.name'))<a href="{{ route('home') }}#about">{{ $author }}</a>@else{{ $author }}@endif{{ $loop->last ? '' : ', ' }}
                        @endforeach
                    </p>
                @endif
                @if ($publication->publisher)<p class="publication-venue">Accepted at {{ $publication->publisher }}</p>@endif
            </header>
            <div class="prose-panel reveal">
                <h2>Abstract</h2>
                <p>{{ $publication->description }}</p>
                @if ($publication->contribution)<h2>Contribution</h2><p>{{ $publication->contribution }}</p>@endif
                @if ($publication->research_topics)<div class="tag-row">@foreach ($publication->research_topics as $topic)<span>{{ $topic }}</span>@endforeach</div>@endif
                <div class="detail-actions">
                    @if ($publication->url)<a class="button button-primary" href="{{ $publication->url }}" target="_blank" rel="noopener noreferrer">OpenReview</a>@endif
                    {{-- @if ($publication->reference_url)<a class="button button-secondary" href="{{ $publication->reference_url }}" target="_blank" rel="noopener noreferrer">Google Scholar</a>@endif --}}
                </div>
            </div>
        </div>
    </article>
</x-frontend::layout>
