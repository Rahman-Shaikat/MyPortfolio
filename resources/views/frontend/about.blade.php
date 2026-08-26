<x-frontend::layout :profile="$profile" :seo="$seo">
    <section class="section-pad page-hero" aria-labelledby="about-page-title">
        <div class="container detail-grid">
            <div class="section-heading reveal">
                <p class="eyebrow">About</p>
                <h1 id="about-page-title" class="page-title">Software engineering built around dependable backend systems.</h1>
            </div>
            <div class="prose-panel reveal">
                <p>{{ $profile->about_paragraph_one }}</p>
                <p>{{ $profile->about_paragraph_two }}</p>
                <div class="detail-actions">
                    <a class="button button-primary" href="{{ route('projects.index') }}">Review projects</a>
                    <a class="button button-secondary" href="{{ route('research.index') }}">Explore AI and LLM research</a>
                    <a class="button button-secondary" href="{{ route('resume.show') }}">View resume</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-pad muted-band" aria-labelledby="capabilities-title">
        <div class="container">
            <div class="section-heading reveal">
                <p class="eyebrow">Capabilities</p>
                <h2 id="capabilities-title">Backend delivery, production operations, and responsible AI research.</h2>
            </div>
            <div class="service-grid">
                @foreach ($profile->about_highlights ?? [] as $highlight)
                    <article class="service-card reveal">
                        <span>{{ str_pad((string) ($loop->index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $highlight['title'] }}</h3>
                        <p>{{ $highlight['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-frontend::layout>
