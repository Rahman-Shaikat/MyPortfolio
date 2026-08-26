<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Publication;
use Illuminate\Support\Str;

class SeoService
{
    /**
     * @return array<string, mixed>
     */
    public function home(Profile $profile): array
    {
        $title = 'Md. Shamsur Rahman | Software Engineer, Laravel Backend & AI Research';
        $description = 'Software Engineer in Dhaka, Bangladesh with 3+ years of experience building Laravel and PHP backends, REST APIs, CMS and e-commerce systems across 20+ projects, with LLM and AI research experience.';
        $canonical = route('home');

        return $this->page($title, $description, $canonical, $this->graph([
            $this->personEntity($profile),
            $this->websiteEntity(),
            $this->webPageEntity($title, $description, $canonical, 'ProfilePage'),
        ]));
    }

    /**
     * @return array<string, mixed>
     */
    public function about(Profile $profile): array
    {
        $title = 'About Md. Shamsur Rahman | Software Engineer & Laravel Developer';
        $description = 'Learn about Md. Shamsur Rahman, a Dhaka-based Software Engineer with 3+ years of Laravel and PHP backend experience across APIs, databases, CMS, e-commerce, production support, and AI research.';
        $canonical = route('about');

        $profilePage = $this->webPageEntity($title, $description, $canonical, 'ProfilePage');
        $profilePage['mainEntity'] = ['@id' => $this->personId()];

        return $this->page($title, $description, $canonical, $this->graph([
            $this->personEntity($profile),
            $profilePage,
        ]));
    }

    /**
     * @return array<string, mixed>
     */
    public function projects(Profile $profile, int $page = 1): array
    {
        $suffix = $page > 1 ? " - Page {$page}" : '';
        $title = "Software Engineering Projects | Md. Shamsur Rahman{$suffix}";
        $description = 'Explore Laravel, PHP, backend systems, REST APIs, CMS and e-commerce projects developed or supported by Software Engineer Md. Shamsur Rahman.';
        $canonical = route('projects.index', $page > 1 ? ['page' => $page] : []);

        return $this->page($title, $description, $canonical, $this->graph([
            $this->webPageEntity($title, $description, $canonical, 'CollectionPage'),
        ]));
    }

    /**
     * @return array<string, mixed>
     */
    public function project(Project $project): array
    {
        $projectCategory = collect($project->technologies ?? [])->first(
            fn (string $technology): bool => in_array($technology, ['E-commerce', 'REST API', 'CMS'], true)
        );
        $title = $projectCategory
            ? "{$project->name} {$projectCategory} Development | Md. Shamsur Rahman"
            : "{$project->name} Development | Md. Shamsur Rahman";
        $description = Str::limit(trim((string) ($project->contribution ?: $project->description)), 155, '');
        $canonical = route('projects.show', $project->slug);
        $image = $project->preview_image ? asset('storage/'.$project->preview_image) : $this->defaultImage();
        $relationship = $project->contribution_type === 'creator' ? 'creator' : 'contributor';

        $creativeWork = array_filter([
            '@type' => 'CreativeWork',
            '@id' => $canonical.'#project',
            'name' => $project->name,
            'url' => $canonical,
            'sameAs' => $project->url,
            'description' => $project->description,
            'image' => $image,
            'keywords' => $project->technologies,
            $relationship => ['@id' => $this->personId()],
            'mainEntityOfPage' => ['@id' => $canonical.'#webpage'],
        ], fn (mixed $value): bool => $value !== null && $value !== '' && $value !== []);

        return $this->page($title, $description, $canonical, $this->graph([
            $this->webPageEntity($title, $description, $canonical, 'WebPage'),
            $creativeWork,
        ]), $image, $project->preview_image ? null : [1200, 630], 'article');
    }

    /**
     * @return array<string, mixed>
     */
    public function research(Profile $profile): array
    {
        $title = 'AI & LLM Research | Md. Shamsur Rahman';
        $description = 'AI and LLM research by Md. Shamsur Rahman covering Bangla language models, LLM evaluation, social bias, cultural commonsense, responsible AI and benchmark development.';
        $canonical = route('research.index');

        return $this->page($title, $description, $canonical, $this->graph([
            $this->personEntity($profile),
            $this->webPageEntity($title, $description, $canonical, 'CollectionPage'),
        ]));
    }

    /**
     * @return array<string, mixed>
     */
    public function publication(Publication $publication): array
    {
        $title = "{$publication->title} | Md. Shamsur Rahman";
        $description = Str::limit(trim((string) $publication->description), 155, '');
        $canonical = route('research.show', $publication->slug);
        $image = $publication->image ? asset('storage/'.$publication->image) : $this->defaultImage();
        $authors = collect($publication->authors ?? [])
            ->map(fn (string $author): array => $author === config('seo.person.name')
                ? ['@type' => 'Person', '@id' => $this->personId(), 'name' => $author]
                : ['@type' => 'Person', 'name' => $author])
            ->all();

        $article = array_filter([
            '@type' => 'ScholarlyArticle',
            '@id' => $canonical.'#article',
            'headline' => $publication->title,
            'description' => $publication->description,
            'url' => $canonical,
            'sameAs' => array_values(array_filter([$publication->url, $publication->reference_url])),
            'author' => $authors,
            'isPartOf' => $publication->publisher ? ['@type' => 'Event', 'name' => $publication->publisher] : null,
            'keywords' => $publication->research_topics,
            'image' => $image,
            'mainEntityOfPage' => ['@id' => $canonical.'#webpage'],
        ], fn (mixed $value): bool => $value !== null && $value !== '' && $value !== []);

        return $this->page($title, $description, $canonical, $this->graph([
            $this->webPageEntity($title, $description, $canonical, 'WebPage'),
            $article,
        ]), $image, $publication->image ? null : [1200, 630], 'article');
    }

    /**
     * @return array<string, mixed>
     */
    public function resume(): array
    {
        $title = 'Resume | Md. Shamsur Rahman - Software Engineer';
        $description = 'Review the resume of Md. Shamsur Rahman, a Software Engineer specializing in Laravel and PHP backend development, REST APIs, MySQL, Redis, Docker and production web systems.';
        $canonical = route('resume.show');

        return $this->page($title, $description, $canonical, $this->graph([
            $this->webPageEntity($title, $description, $canonical, 'ProfilePage'),
        ]));
    }

    /**
     * @return array<string, mixed>
     */
    public function contact(): array
    {
        $title = 'Contact Md. Shamsur Rahman | Software Engineer';
        $description = 'Contact Md. Shamsur Rahman about Laravel development, PHP backend engineering, REST APIs, CMS, e-commerce systems, integrations and production application support.';
        $canonical = route('contact');

        return $this->page($title, $description, $canonical, $this->graph([
            $this->webPageEntity($title, $description, $canonical, 'ContactPage'),
        ]));
    }

    /**
     * @param  array<string, mixed>  $structuredData
     * @param  array{0: int, 1: int}|null  $imageDimensions
     * @return array<string, mixed>
     */
    private function page(
        string $title,
        string $description,
        string $canonical,
        array $structuredData,
        ?string $image = null,
        ?array $imageDimensions = [1200, 630],
        string $ogType = 'website',
    ): array {
        $image ??= $this->defaultImage();

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'robots' => config('seo.robots'),
            'ogTitle' => $title,
            'ogDescription' => $description,
            'ogImage' => $image,
            'ogType' => $ogType,
            'ogImageWidth' => $imageDimensions[0] ?? null,
            'ogImageHeight' => $imageDimensions[1] ?? null,
            'twitterTitle' => $title,
            'twitterDescription' => $description,
            'twitterImage' => $image,
            'structuredData' => $structuredData,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function personEntity(Profile $profile): array
    {
        $profileLinks = [
            $profile->linkedin_url,
            $profile->github_url,
            $profile->medium_url,
            $profile->facebook_url,
            $profile->instagram_url,
        ];

        return [
            '@type' => 'Person',
            '@id' => $this->personId(),
            'name' => config('seo.person.name'),
            'url' => route('home'),
            'image' => $profile->profile_image ? asset('storage/'.$profile->profile_image) : asset('assets/images/My_Pic.png'),
            'jobTitle' => config('seo.person.job_title'),
            'description' => config('seo.person.description'),
            'homeLocation' => [
                '@type' => 'Place',
                'name' => config('seo.person.location'),
            ],
            'sameAs' => collect([...config('seo.person.same_as'), ...$profileLinks])->filter()->unique()->values()->all(),
            'knowsAbout' => config('seo.person.knows_about'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function websiteEntity(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => $this->siteUrl().'#website',
            'url' => route('home'),
            'name' => config('seo.site_name'),
            'publisher' => ['@id' => $this->personId()],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function webPageEntity(string $title, string $description, string $canonical, string $type): array
    {
        return [
            '@type' => $type,
            '@id' => $canonical.'#webpage',
            'url' => $canonical,
            'name' => $title,
            'description' => $description,
            'isPartOf' => ['@id' => $this->siteUrl().'#website'],
            'about' => ['@id' => $this->personId()],
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $entities
     * @return array<string, mixed>
     */
    private function graph(array $entities): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => $entities,
        ];
    }

    private function personId(): string
    {
        return $this->siteUrl().'#person';
    }

    private function siteUrl(): string
    {
        return rtrim((string) config('app.url'), '/').'/';
    }

    private function defaultImage(): string
    {
        return asset(config('seo.default_image'));
    }
}
