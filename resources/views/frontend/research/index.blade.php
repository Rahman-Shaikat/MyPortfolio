<x-frontend::layout :profile="$profile" :seo="$seo">
    <section class="section-pad page-hero muted-band" aria-labelledby="research-page-title">
        <div class="container">
            <div class="section-heading reveal">
                <p class="eyebrow">AI &amp; LLM research</p>
                <h1 id="research-page-title" class="page-title">Evaluating social bias and cultural commonsense in Bangla LLMs.</h1>
                <p class="page-lede">Research interests include responsible AI, NLP, benchmark development, LLM evaluation, Bangla language models, social bias, and culturally grounded evaluation.</p>
            </div>
            <div class="research-links reveal">
                <a class="button button-secondary" href="{{ config('seo.research.scholar_url') }}" target="_blank" rel="noopener noreferrer">Google Scholar</a>
                <a class="button button-secondary" href="{{ config('seo.research.openreview_url') }}" target="_blank" rel="noopener noreferrer">OpenReview</a>
            </div>
            <div class="research-list">
                @forelse ($publications as $publication)@include('frontend.partials.publication-card', ['publication' => $publication])@empty<p class="empty-state">No published research is available yet.</p>@endforelse
            </div>
        </div>
    </section>
</x-frontend::layout>
