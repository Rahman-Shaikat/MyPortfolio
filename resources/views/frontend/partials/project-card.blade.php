<article class="project-card reveal">
    @if ($project->preview_image)
        <div class="project-media project-media-image">
            <img src="{{ asset('storage/'.$project->preview_image) }}" alt="{{ $project->name }} project preview from {{ config('seo.person.name') }}'s portfolio" width="1200" height="675" loading="lazy">
        </div>
    @else
        <div class="project-media project-media-{{ ['commerce', 'api', 'dashboard'][($project->id - 1) % 3] }}" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </div>
    @endif
    <div class="project-body">
        <h3><a href="{{ route('projects.show', $project->slug) }}">{{ $project->name }}</a></h3>
        <p>{{ $project->description }}</p>
        <div class="tag-row">
            @foreach ($project->technologies ?? [] as $technology)
                <span>{{ $technology }}</span>
            @endforeach
        </div>
        <div class="project-actions">
            <a href="{{ route('projects.show', $project->slug) }}">View case study</a>
            @if ($project->url)
                <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer">Visit Project</a>
            @endif
        </div>
    </div>
</article>
