<?php

use App\Models\Project;
use Database\Seeders\ProjectSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(LazilyRefreshDatabase::class);

test('the application returns a successful response', function () {
    $this->seed(ProjectSeeder::class);

    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee(asset('assets/images/favicon.ico'), false)
        ->assertSee('bdnews24.com')
        ->assertSee('Sanitation Knowledge Repository')
        ->assertSee('Jhingephul Publication')
        ->assertSee('Taan')
        ->assertSee('Khalid Sangeet')
        ->assertSee('Step Footwear')
        ->assertDontSee('Resume Engineer');
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

test('only the private admin login URL shows the login form', function () {
    $this->get(route('admin.login'))
        ->assertSuccessful()
        ->assertSee('Admin Login')
        ->assertSee('Sign In');

    $this->get('/admin/login')->assertNotFound();
    $this->get('/admin/login/U1GFG_45vj-ik7BD_VFji_khr0v')->assertNotFound();
    $this->post('/admin/login')->assertNotFound();
});

test('admin routes are concealed from unauthenticated visitors', function (string $method, string $url) {
    $response = $this->call($method, $url);

    $response->assertNotFound();
    expect($response->headers->has('Location'))->toBeFalse();
})->with([
    'admin entry point' => ['GET', '/admin'],
    'dashboard' => ['GET', '/admin/dashboard'],
    'projects' => ['GET', '/admin/projects'],
    'publications' => ['GET', '/admin/publications'],
    'profiles' => ['GET', '/admin/profiles'],
    'logout' => ['POST', '/admin/logout'],
]);

test('the admin login form opens the dashboard', function () {
    config()->set('admin.email', 'admin@example.com');
    config()->set('admin.password_hash', Hash::make('correct-password'));

    $this->from(route('admin.login'))->post(route('admin.login.store'), [
        'email' => 'admin@example.com',
        'password' => 'wrong-password',
    ])->assertRedirect(route('admin.login'))
        ->assertSessionHasErrors('email');

    $response = $this->post(route('admin.login.store'), [
        'email' => 'admin@example.com',
        'password' => 'correct-password',
    ]);

    $response->assertRedirect(route('admin.dashboard'));

    $this->get('/admin/dashboard')
        ->assertSuccessful()
        ->assertSee('Admin Dashboard')
        ->assertSee('Featured Portfolio Items');
});

test('the private admin login endpoint is rate limited', function () {
    config()->set('admin.email', 'admin@example.com');
    config()->set('admin.password_hash', Hash::make('correct-password'));

    foreach (range(1, 5) as $attempt) {
        $this->post(route('admin.login.store'), [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    $this->post(route('admin.login.store'), [
        'email' => 'admin@example.com',
        'password' => 'wrong-password',
    ])->assertTooManyRequests();
});
