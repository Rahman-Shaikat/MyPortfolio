{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach (['home', 'projects.index', 'research.index', 'habit-tracker', 'contact'] as $route)
    <url><loc>{{ $seoService->url($route) }}</loc></url>
@endforeach
@foreach ($projects as $project)
    <url><loc>{{ $seoService->url('projects.show', ['slug' => $project->slug]) }}</loc><lastmod>{{ $project->updated_at->toAtomString() }}</lastmod></url>
@endforeach
@foreach ($publications as $publication)
    <url><loc>{{ $seoService->url('research.show', ['slug' => $publication->slug]) }}</loc><lastmod>{{ $publication->updated_at->toAtomString() }}</lastmod></url>
@endforeach
</urlset>
