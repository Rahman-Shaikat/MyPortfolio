<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

test('guests cannot access project management', function () {
    $this->get(route('admin.projects.index'))
        ->assertRedirect(route('admin.login'));
});

test('an authenticated admin can search project records', function () {
    Project::factory()->create(['name' => 'Visible Laravel Project']);
    Project::factory()->create(['name' => 'Different Portfolio Entry']);

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->get(route('admin.projects.index', ['search' => 'Laravel']));

    $response->assertSuccessful()
        ->assertSee('Visible Laravel Project')
        ->assertDontSee('Different Portfolio Entry');
});

test('an authenticated admin sees the enhanced project image uploader', function () {
    $this->withSession(['admin_authenticated' => true])
        ->get(route('admin.projects.create'))
        ->assertSuccessful()
        ->assertSee('Choose preview image')
        ->assertSee('data-preview-upload-zone', false);
});

test('an authenticated admin can create a project', function () {
    Storage::fake('public');

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->post(route('admin.projects.store'), [
            'name' => 'Portfolio Content Platform',
            'slug' => '',
            'url' => 'https://example.com',
            'description' => 'A content platform built for a publishing team.',
            'technologies' => 'Laravel, PHP, MySQL, laravel',
            'preview_image' => UploadedFile::fake()->image('project-preview.jpg', 1200, 675),
            'is_personal' => '1',
            'sort_order' => '9',
            'status' => '1',
        ]);

    $response->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $project = Project::query()->where('slug', 'portfolio-content-platform')->firstOrFail();

    expect($project->technologies)->toBe(['Laravel', 'PHP', 'MySQL'])
        ->and($project->is_personal)->toBeTrue()
        ->and($project->status)->toBeTrue()
        ->and($project->sort_order)->toBe(9)
        ->and($project->preview_image)->not->toBeNull();

    Storage::disk('public')->assertExists($project->preview_image);
});

test('project creation requires valid data and a unique slug', function () {
    Project::factory()->create(['slug' => 'existing-project']);

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->from(route('admin.projects.create'))
        ->post(route('admin.projects.store'), [
            'name' => 'Another Project',
            'slug' => 'existing-project',
            'url' => 'not-a-url',
            'technologies' => 'Laravel',
            'preview_image' => UploadedFile::fake()->create('project-preview.pdf', 100, 'application/pdf'),
            'is_personal' => '0',
            'sort_order' => 'first',
            'status' => 'visible',
        ]);

    $response->assertRedirect(route('admin.projects.create'))
        ->assertSessionHasErrors(['slug', 'url', 'preview_image', 'sort_order', 'status']);
});

test('an authenticated admin can update a project', function () {
    $project = Project::factory()->create([
        'name' => 'Original Project',
        'slug' => 'original-project',
    ]);

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->put(route('admin.projects.update', $project), [
            'name' => 'Updated Project',
            'slug' => 'updated-project',
            'url' => 'https://updated.example.com',
            'description' => 'Updated project description.',
            'technologies' => 'Laravel, Redis',
            'is_personal' => '0',
            'sort_order' => '2',
            'status' => '0',
        ]);

    $response->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $project->refresh();

    expect($project->name)->toBe('Updated Project')
        ->and($project->slug)->toBe('updated-project')
        ->and($project->technologies)->toBe(['Laravel', 'Redis'])
        ->and($project->status)->toBeFalse();
});

test('an authenticated admin can replace a project preview image', function () {
    Storage::fake('public');

    $originalPreviewImage = UploadedFile::fake()
        ->image('original-preview.jpg', 1200, 675)
        ->store('projects', 'public');
    $project = Project::factory()->create(['preview_image' => $originalPreviewImage]);

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->put(route('admin.projects.update', $project), [
            'name' => $project->name,
            'slug' => $project->slug,
            'url' => $project->url,
            'description' => $project->description,
            'technologies' => collect($project->technologies)->join(', '),
            'preview_image' => UploadedFile::fake()->image('replacement-preview.webp', 1200, 675),
            'is_personal' => (int) $project->is_personal,
            'sort_order' => $project->sort_order,
            'status' => (int) $project->status,
        ]);

    $response->assertRedirect(route('admin.projects.index'));

    $project->refresh();

    expect($project->preview_image)->not->toBe($originalPreviewImage);
    Storage::disk('public')->assertMissing($originalPreviewImage);
    Storage::disk('public')->assertExists($project->preview_image);
});

test('an authenticated admin can remove a project preview image', function () {
    Storage::fake('public');

    $previewImage = UploadedFile::fake()
        ->image('project-preview.jpg', 1200, 675)
        ->store('projects', 'public');
    $project = Project::factory()->create(['preview_image' => $previewImage]);

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->put(route('admin.projects.update', $project), [
            'name' => $project->name,
            'slug' => $project->slug,
            'url' => $project->url,
            'description' => $project->description,
            'technologies' => collect($project->technologies)->join(', '),
            'remove_preview_image' => '1',
            'is_personal' => (int) $project->is_personal,
            'sort_order' => $project->sort_order,
            'status' => (int) $project->status,
        ]);

    $response->assertRedirect(route('admin.projects.index'));

    expect($project->refresh()->preview_image)->toBeNull();
    Storage::disk('public')->assertMissing($previewImage);
});

test('an authenticated admin can delete a project', function () {
    Storage::fake('public');

    $previewImage = UploadedFile::fake()
        ->image('project-preview.jpg', 1200, 675)
        ->store('projects', 'public');
    $project = Project::factory()->create(['preview_image' => $previewImage]);

    $response = $this
        ->withSession(['admin_authenticated' => true])
        ->delete(route('admin.projects.destroy', $project));

    $response->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertModelMissing($project);
    Storage::disk('public')->assertMissing($previewImage);
});
