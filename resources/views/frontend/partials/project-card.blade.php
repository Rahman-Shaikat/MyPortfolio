<article class="project-card reveal">
    @if ($project->preview_image)
        <div class="project-media project-media-image">
            <img src="{{ asset('storage/'.$project->preview_image) }}" alt="{{ $project->name }} project preview" loading="lazy">
        </div>
    @else
        <div class="project-media project-media-{{ ['commerce', 'api', 'dashboard'][($project->id - 1) % 3] }}" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </div>
    @endif
    <div class="project-body">
        <h3>{{ $project->name }}</h3>
        <p>{{ $project->description }}</p>
        <div class="tag-row">
            @foreach ($project->technologies ?? [] as $technology)
                <span>{{ $technology }}</span>
            @endforeach
        </div>
        @if ($project->url)
            <div class="project-actions">
                <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer">Visit Project</a>
            </div>
        @endif
    </div>
</article>
