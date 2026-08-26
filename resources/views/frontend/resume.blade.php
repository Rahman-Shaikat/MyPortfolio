<x-frontend::layout :profile="$profile" :seo="$seo">
    <section class="section-pad page-hero" aria-labelledby="resume-title">
        <div class="container detail-grid">
            <div class="section-heading reveal">
                <p class="eyebrow">Resume</p>
                <h1 id="resume-title" class="page-title">{{ $profile->name }}, {{ $profile->professional_title }}</h1>
                <p class="page-lede">Laravel and PHP backend engineer based in {{ $profile->location }}, with 3+ years of experience across 20+ production and client projects.</p>
                <div class="detail-actions">
                    <a class="button button-primary" href="{{ route('resume.file') }}" target="_blank" rel="noopener noreferrer">Open PDF resume</a>
                    <a class="button button-secondary" href="{{ route('projects.index') }}">View engineering projects</a>
                    <a class="button button-secondary" href="{{ route('research.index') }}">View research</a>
                </div>
            </div>
            <div class="resume-summary reveal">
                <h2>Technical focus</h2>
                <div class="skill-grid">
                    @foreach ($profile->skills ?? [] as $skill)
                        <span>{{ $skill }}</span>
                    @endforeach
                </div>
                <p>{{ $profile->about_paragraph_two }}</p>
            </div>
        </div>
    </section>
</x-frontend::layout>
