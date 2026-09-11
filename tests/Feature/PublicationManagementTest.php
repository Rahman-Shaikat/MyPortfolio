<?php

use App\Models\Publication;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

test('guests cannot access publication management', function () {
    $this->get(route('admin.publications.index'))
        ->assertNotFound();
});

test('an authenticated admin can search publication records', function () {
    Publication::factory()->create(['title' => 'Laravel Architecture in Practice']);
    Publication::factory()->create(['title' => 'Different Engineering Article']);

    $this->withSession(['admin_authenticated' => true])
        ->get(route('admin.publications.index', ['search' => 'Laravel']))
        ->assertSuccessful()
        ->assertSee('Laravel Architecture in Practice')
        ->assertDontSee('Different Engineering Article');
});

test('an authenticated admin can create a publication with an image and url', function () {
    Storage::fake('public');

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->post(route('admin.publications.store'), [
            'title' => 'Building Reliable Laravel Applications',
            'publisher' => 'Engineering Weekly',
            'published_at' => '2026-08-20',
            'description' => 'A practical article about reliable Laravel application architecture.',
            'image' => UploadedFile::fake()->image('publication-cover.jpg', 1200, 675),
            'url' => 'https://example.com/publications/reliable-laravel',
            'sort_order' => '3',
            'status' => '1',
        ]);

    $response->assertRedirect(route('admin.publications.index'))
        ->assertSessionHas('success');

    $publication = Publication::query()->where('title', 'Building Reliable Laravel Applications')->firstOrFail();

    expect($publication->publisher)->toBe('Engineering Weekly')
        ->and($publication->published_at->format('Y-m-d'))->toBe('2026-08-20')
        ->and($publication->url)->toBe('https://example.com/publications/reliable-laravel')
        ->and($publication->image)->not->toBeNull()
        ->and($publication->status)->toBeTrue();

    Storage::disk('public')->assertExists($publication->image);
});

test('publication creation requires valid data', function () {
    $this->withSession(['admin_authenticated' => true])
        ->from(route('admin.publications.create'))
        ->post(route('admin.publications.store'), [
            'title' => '',
            'published_at' => 'not-a-date',
            'image' => UploadedFile::fake()->create('publication.pdf', 100, 'application/pdf'),
            'url' => 'not-a-url',
            'sort_order' => '-1',
            'status' => 'visible',
        ])
        ->assertRedirect(route('admin.publications.create'))
        ->assertSessionHasErrors(['title', 'published_at', 'image', 'url', 'sort_order', 'status']);
});

test('an authenticated admin can update a publication', function () {
    $publication = Publication::factory()->create();

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->put(route('admin.publications.update', $publication), [
            'title' => 'Updated Publication Title',
            'publisher' => 'Updated Publisher',
            'published_at' => '2026-07-15',
            'description' => 'Updated publication description.',
            'url' => 'https://example.com/updated-publication',
            'sort_order' => '2',
            'status' => '0',
        ]);

    $response->assertRedirect(route('admin.publications.index'))
        ->assertSessionHas('success');

    $publication->refresh();

    expect($publication->title)->toBe('Updated Publication Title')
        ->and($publication->publisher)->toBe('Updated Publisher')
        ->and($publication->published_at->format('Y-m-d'))->toBe('2026-07-15')
        ->and($publication->url)->toBe('https://example.com/updated-publication')
        ->and($publication->status)->toBeFalse();
});

test('an authenticated admin can replace a publication image', function () {
    Storage::fake('public');

    $originalImage = UploadedFile::fake()
        ->image('original-publication.jpg', 1200, 675)
        ->store('publications', 'public');
    $publication = Publication::factory()->create(['image' => $originalImage]);

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->put(route('admin.publications.update', $publication), publicationPayload($publication, [
            'image' => UploadedFile::fake()->image('replacement-publication.webp', 1200, 675),
        ]));

    $response->assertRedirect(route('admin.publications.index'));

    $publication->refresh();

    expect($publication->image)->not->toBe($originalImage);
    Storage::disk('public')->assertMissing($originalImage);
    Storage::disk('public')->assertExists($publication->image);
});

test('an authenticated admin can remove a publication image', function () {
    Storage::fake('public');

    $image = UploadedFile::fake()
        ->image('publication.jpg', 1200, 675)
        ->store('publications', 'public');
    $publication = Publication::factory()->create(['image' => $image]);

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->put(route('admin.publications.update', $publication), publicationPayload($publication, [
            'remove_image' => '1',
        ]));

    $response->assertRedirect(route('admin.publications.index'));

    expect($publication->refresh()->image)->toBeNull();
    Storage::disk('public')->assertMissing($image);
});

test('an authenticated admin can delete a publication and its image', function () {
    Storage::fake('public');

    $image = UploadedFile::fake()
        ->image('publication.jpg', 1200, 675)
        ->store('publications', 'public');
    $publication = Publication::factory()->create(['image' => $image]);

    $this->withSession(['admin_authenticated' => true])
        ->delete(route('admin.publications.destroy', $publication))
        ->assertRedirect(route('admin.publications.index'))
        ->assertSessionHas('success');

    $this->assertModelMissing($publication);
    Storage::disk('public')->assertMissing($image);
});

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function publicationPayload(Publication $publication, array $overrides = []): array
{
    return array_merge([
        'title' => $publication->title,
        'publisher' => $publication->publisher,
        'published_at' => $publication->published_at?->format('Y-m-d'),
        'description' => $publication->description,
        'url' => $publication->url,
        'sort_order' => $publication->sort_order,
        'status' => (int) $publication->status,
    ], $overrides);
}
