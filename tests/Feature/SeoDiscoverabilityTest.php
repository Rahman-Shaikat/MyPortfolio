<?php

use App\Models\Profile;
use App\Models\Project;
use App\Models\Publication;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\URL;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    config()->set('app.url', 'https://portfolio.example.com');
    config()->set('seo.url', 'https://portfolio.example.com');
    config()->set('seo.enforce_canonical', false);
    URL::forceRootUrl('https://portfolio.example.com');
    URL::forceScheme('https');
    Profile::factory()->create([
        'name' => 'Md. Shamsur Rahman',
        'hero_title_line_one' => 'Md. Shamsur Rahman',
        'hero_title_line_two' => 'Software Engineer',
        'about_paragraph_one' => 'Laravel backend engineer in Dhaka, Bangladesh.',
        'about_paragraph_two' => 'Three years of production engineering experience.',
        'location' => 'Dhaka, Bangladesh',
        'github_url' => 'https://github.com/Rahman-Shaikat',
        'linkedin_url' => 'https://www.linkedin.com/in/rahman-shaikat-7254651b7',
    ]);
});

test('the home page exposes complete metadata and a stable person entity', function () {
    $response = $this->get(route('home'));

    $response->assertSuccessful()
        ->assertSee('<title>Md. Shamsur Rahman (Shaikat) | Software Engineer &amp; Laravel Developer</title>', false)
        ->assertSee('<meta name="description"', false)
        ->assertSee('<link rel="canonical" href="https://portfolio.example.com">', false)
        ->assertSee('<meta property="og:image" content="https://portfolio.example.com/assets/images/og/md-shamsur-rahman-og.png">', false)
        ->assertSee('"@id":"https://portfolio.example.com/#person"', false)
        ->assertSee('"@type":"WebSite"', false)
        ->assertSee('"knowsAbout"', false)
        ->assertDontSee('<meta name="keywords"', false);

    expect(substr_count($response->getContent(), '<title>'))->toBe(1)
        ->and(substr_count($response->getContent(), '<link rel="canonical"'))->toBe(1);
});

test('project case studies have unique metadata and factual creative work schema', function () {
    $project = Project::factory()->create([
        'name' => 'Taan',
        'slug' => 'taan',
        'description' => 'A Laravel e-commerce platform.',
        'contribution' => 'Independently built the Laravel platform and payment integration.',
        'contribution_type' => 'creator',
    ]);

    $this->get(route('projects.show', $project->slug))
        ->assertSuccessful()
        ->assertSee('<title>Taan Development | Md. Shamsur Rahman</title>', false)
        ->assertSee('"@type":"CreativeWork"', false)
        ->assertSee('"creator":{"@id":"https://portfolio.example.com/#person"}', false)
        ->assertSee('Independently built the Laravel platform');
});

test('inactive projects and publications are not publicly accessible', function () {
    $project = Project::factory()->inactive()->create();
    $publication = Publication::factory()->inactive()->create();

    $this->get(route('projects.show', $project->slug))->assertNotFound();
    $this->get(route('research.show', $publication->slug))->assertNotFound();
});

test('the standalone about page is not available', function () {
    $this->get('/about')->assertNotFound();
});

test('research publication pages expose scholarly article schema and source links', function () {
    $publication = Publication::factory()->create([
        'title' => 'BaSCo: A Benchmark for Evaluating Social Bias and Cultural Commonsense in Bangla LLMs',
        'slug' => 'basco-bangla-llms',
        'publisher' => 'MusIML Workshop, ICML 2026',
        'url' => config('seo.research.openreview_url'),
        'reference_url' => config('seo.research.scholar_url'),
    ]);

    $this->get(route('research.show', $publication->slug))
        ->assertSuccessful()
        ->assertSee('"@type":"ScholarlyArticle"', false)
        ->assertSee('MusIML Workshop, ICML 2026')
        ->assertSee(config('seo.research.openreview_url'))
        ->assertSee('citation_for_view=HSHJO28AAAAJ:d1gkVwhDpl0C', false);
});

test('the XML sitemap contains indexable public records only', function () {
    $activeProject = Project::factory()->create(['slug' => 'active-project']);
    $inactiveProject = Project::factory()->inactive()->create(['slug' => 'private-project']);
    $publication = Publication::factory()->create(['slug' => 'published-paper']);

    $this->get(route('sitemap'))
        ->assertSuccessful()
        ->assertHeader('content-type', 'application/xml; charset=UTF-8')
        ->assertSee(route('projects.show', $activeProject->slug), false)
        ->assertSee(route('research.show', $publication->slug), false)
        ->assertDontSee(route('projects.show', $inactiveProject->slug), false)
        ->assertDontSee('/admin', false);
});

test('robots and llms discovery files expose the public portfolio map', function () {
    $this->get(route('robots'))
        ->assertSuccessful()
        ->assertSee('Disallow: /admin/', false)
        ->assertSee('User-agent: OAI-SearchBot', false)
        ->assertSee('User-agent: Claude-SearchBot', false)
        ->assertSee('User-agent: Google-Extended', false)
        ->assertSee('User-agent: GPTBot', false)
        ->assertSee('Sitemap: https://portfolio.example.com/sitemap.xml', false);

    $this->get(route('llms'))
        ->assertSuccessful()
        ->assertSee('Md. Shamsur Rahman')
        ->assertSee('BaSCo')
        ->assertSee('https://portfolio.example.com/projects', false);
});

test('admin pages instruct search engines not to index them', function () {
    $this->get(route('admin.login'))
        ->assertSuccessful()
        ->assertSee('<meta name="robots" content="noindex,nofollow,noarchive">', false);
});

test('production SEO URLs and identity remain consistent when served from another host', function () {
    config()->set('seo.url', 'https://shaikat.xyz');
    Profile::query()->first()->update(['seo_description' => 'Laravel developer and web developer in Bangladesh.']);

    $response = $this->get(route('home'))->assertSuccessful()
        ->assertSee('<link rel="canonical" href="https://shaikat.xyz">', false)
        ->assertSee('<meta property="og:url" content="https://shaikat.xyz">', false)
        ->assertSee('<meta name="description" content="Laravel developer and web developer in Bangladesh.">', false)
        ->assertSee('Also known as Shaikat');

    preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $response->getContent(), $matches);
    $graph = collect(json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR)['@graph']);
    $person = $graph->firstWhere('@type', 'Person');
    $page = $graph->firstWhere('@type', 'ProfilePage');

    expect($person['@id'])->toBe('https://shaikat.xyz/#person')
        ->and($person['alternateName'])->toContain('Shaikat', 'Shamsur Rahman')
        ->and($person['sameAs'])->not->toContain(config('seo.research.openreview_url'))
        ->and($page['mainEntity']['@id'])->toBe($person['@id']);

    $this->get(route('sitemap'))->assertSuccessful()
        ->assertSee('<loc>https://shaikat.xyz</loc>', false)
        ->assertDontSee('portfolio.example.com');
    $this->get(route('robots'))->assertSuccessful()
        ->assertSee('Sitemap: https://shaikat.xyz/sitemap.xml', false);
    $this->get(route('llms'))->assertSuccessful()
        ->assertSee('[GitHub](https://github.com/Rahman-Shaikat)', false)
        ->assertSee('https://shaikat.xyz');
    $this->get(route('projects.index', ['page' => 2]))->assertSuccessful()
        ->assertSee('<link rel="canonical" href="https://shaikat.xyz/projects?page=2">', false);
});

test('canonical redirects preserve paths and query strings when enabled', function () {
    config()->set('seo.url', 'https://shaikat.xyz');
    config()->set('seo.enforce_canonical', true);

    $this->get('http://www.shaikat.xyz/projects?page=2')
        ->assertStatus(301)
        ->assertRedirect('https://shaikat.xyz/projects?page=2');

    $this->get('https://shaikat.xyz/')->assertSuccessful();
});
