@php
    $demoUrl = str_starts_with($project['demo_url'], '#') ? route('home').$project['demo_url'] : $project['demo_url'];
    $sourceUrl = str_starts_with($project['source_url'], '#') ? route('home').$project['source_url'] : $project['source_url'];
@endphp

<article class="project-card reveal">
    <div class="project-media {{ $project['media'] }}" aria-hidden="true">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="project-body">
        <h3>{{ $project['title'] }}</h3>
        <p>{{ $project['description'] }}</p>
        <div class="tag-row">
            @foreach ($project['tags'] as $tag)
                <span>{{ $tag }}</span>
            @endforeach
        </div>
        <div class="project-actions">
            <a href="{{ $demoUrl }}">Demo</a>
            <a href="{{ $sourceUrl }}">Source</a>
        </div>
    </div>
</article>
