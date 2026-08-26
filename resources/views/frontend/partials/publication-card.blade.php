<article class="thought-card reveal">
    <span>{{ $publication->publisher ?: 'Research publication' }}</span>
    <h3><a href="{{ route('research.show', $publication->slug) }}">{{ $publication->title }}</a></h3>
    <p>{{ $publication->description }}</p>
    <a class="text-link" href="{{ route('research.show', $publication->slug) }}">Read publication details</a>
</article>
