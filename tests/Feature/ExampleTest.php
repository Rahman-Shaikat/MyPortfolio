<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertSuccessful();
});

test('the projects page returns a successful response', function () {
    $response = $this->get('/projects');

    $response->assertSuccessful()
        ->assertSee('All projects')
        ->assertSee('Commerce Operations Platform')
        ->assertSee('Showing 1-3 of 6 projects');
});

test('the projects page can show the next page of projects', function () {
    $response = $this->get('/projects?page=2');

    $response->assertSuccessful()
        ->assertSee('Performance Review Toolkit')
        ->assertSee('Showing 4-6 of 6 projects');
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
        ->assertSee('Recent Portfolio Items');
});
