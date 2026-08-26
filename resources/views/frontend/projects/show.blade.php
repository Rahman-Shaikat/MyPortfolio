<x-frontend::layout :profile="$profile" :seo="$seo">
    <article>
        <header class="section-pad page-hero project-detail-hero">
            <div class="container detail-grid">
                <div class="section-heading reveal">
                    <p class="eyebrow">Project case study</p>
                    <h1 class="page-title">{{ $project->name }}</h1>
                    <p class="page-lede">{{ $project->description }}</p>
                    <div class="tag-row">
                        @foreach ($project->technologies ?? [] as $technology)<span>{{ $technology }}</span>@endforeach
                    </div>
                    <div class="detail-actions">
                        @if ($project->url)<a class="button button-primary" href="{{ $project->url }}" target="_blank" rel="noopener noreferrer">Visit live project</a>@endif
                        <a class="button button-secondary" href="{{ route('projects.index') }}">All projects</a>
                    </div>
                </div>
                @if ($project->preview_image)
                    <figure class="detail-media reveal"><img src="{{ asset('storage/'.$project->preview_image) }}" alt="{{ $project->name }} project interface" width="1200" height="675"></figure>
                @else
                    <div class="detail-media project-media project-media-api reveal" aria-hidden="true"><span></span><span></span><span></span></div>
                @endif
            </div>
        </header>

        <section class="section-pad muted-band" aria-labelledby="contribution-title">
            <div class="container detail-grid">
                <div class="section-heading reveal"><p class="eyebrow">Contribution</p><h2 id="contribution-title">Role and engineering work</h2></div>
                <div class="prose-panel reveal">
                    @if ($project->role)<p class="detail-label">Role</p><h3>{{ $project->role }}</h3>@endif
                    @if ($project->contribution)<p>{{ $project->contribution }}</p>@endif
                    @if ($project->responsibilities)
                        <h3>Responsibilities</h3>
                        <ul class="detail-list">@foreach ($project->responsibilities as $responsibility)<li>{{ $responsibility }}</li>@endforeach</ul>
                    @endif
                    @if ($project->challenges)<h3>Challenges</h3><p>{{ $project->challenges }}</p>@endif
                    @if ($project->outcome)<h3>Outcome</h3><p>{{ $project->outcome }}</p>@endif
                </div>
            </div>
        </section>
    </article>

    @if ($relatedProjects->isNotEmpty())
        <section class="section-pad" aria-labelledby="related-projects-title"><div class="container"><div class="section-heading reveal"><p class="eyebrow">More work</p><h2 id="related-projects-title">Related engineering projects</h2></div><div class="project-grid">@foreach ($relatedProjects as $relatedProject)@include('frontend.partials.project-card', ['project' => $relatedProject])@endforeach</div></div></section>
    @endif
</x-frontend::layout>
