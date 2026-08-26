{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ([route('home'), route('about'), route('projects.index'), route('research.index'), route('resume.show'), route('contact')] as $url)
    <url><loc>{{ $url }}</loc></url>
@endforeach
@foreach ($projects as $project)
    <url><loc>{{ route('projects.show', $project->slug) }}</loc><lastmod>{{ $project->updated_at->toAtomString() }}</lastmod></url>
@endforeach
@foreach ($publications as $publication)
    <url><loc>{{ route('research.show', $publication->slug) }}</loc><lastmod>{{ $publication->updated_at->toAtomString() }}</lastmod></url>
@endforeach
</urlset>
