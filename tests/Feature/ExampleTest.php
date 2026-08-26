<?php

use App\Models\Project;
use Database\Seeders\ProjectSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('the application returns a successful response', function () {
    $this->seed(ProjectSeeder::class);

    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee('bdnews24.com')
        ->assertSee('Sanitation Knowledge Repository')
        ->assertSee('Jhingephul Publication')
        ->assertDontSee('Taan');
});

test('the projects page returns a successful response', function () {
    $this->seed(ProjectSeeder::class);

    $response = $this->get('/projects');

    $response->assertSuccessful()
        ->assertSee('All projects')
        ->assertSee('bdnews24.com')
        ->assertSee('Showing 1-3 of 8 projects');
});

test('the projects page can show the next page of projects', function () {
    $this->seed(ProjectSeeder::class);

    $response = $this->get('/projects?page=2');

    $response->assertSuccessful()
        ->assertSee('Taan')
        ->assertSee('Step Footwear')
        ->assertSee('Showing 4-6 of 8 projects');
});

test('the projects page excludes inactive projects', function () {
    $this->seed(ProjectSeeder::class);

    Project::factory()->inactive()->create([
        'name' => 'Hidden Portfolio Project',
        'slug' => 'hidden-portfolio-project',
        'sort_order' => 0,
    ]);

    $this->get('/projects')
        ->assertSuccessful()
        ->assertDontSee('Hidden Portfolio Project')
        ->assertSee('Showing 1-3 of 8 projects');
});

test('project technologies are cast to an array', function () {
    $project = Project::factory()->create([
        'technologies' => ['Laravel', 'Redis'],
    ]);

    expect($project->fresh()->technologies)->toBe(['Laravel', 'Redis']);
});

test('project preview images are rendered on public project cards', function () {
    Project::factory()->create([
        'preview_image' => 'projects/project-preview.jpg',
        'sort_order' => 0,
    ]);

    $this->get('/projects')
        ->assertSuccessful()
        ->assertSee(asset('storage/projects/project-preview.jpg'), false);
});

test('the admin login page returns a successful response', function () {
    $response = $this->get('/admin/login');

    $response->assertSuccessful()
        ->assertSee('Admin Login')
        ->assertSee('Sign In');
});

test('the admin dashboard redirects guests to login', function () {
    $response = $this->get('/admin/dashboard');

    $response->assertRedirect(route('admin.login'));
});

test('the admin login form opens the dashboard', function () {
    $response = $this->post('/admin/login', [
        'email' => 'admin@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard'));

    $this->get('/admin/dashboard')
        ->assertSuccessful()
        ->assertSee('Admin Dashboard')
        ->assertSee('Featured Portfolio Items');
});
