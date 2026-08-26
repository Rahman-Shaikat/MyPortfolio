<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$projects = [
    [
        'title' => 'Commerce Operations Platform',
        'description' => 'A Laravel eCommerce back office for orders, inventory, promotions, and payment reconciliation.',
        'tags' => ['Laravel', 'MySQL', 'Payments'],
        'media' => 'project-media-commerce',
        'demo_url' => '#contact',
        'source_url' => '#contact',
    ],
    [
        'title' => 'API Integration Hub',
        'description' => 'A REST API service that connects CRM, billing, and notification providers with resilient webhook handling.',
        'tags' => ['REST API', 'Queues', 'Webhooks'],
        'media' => 'project-media-api',
        'demo_url' => '#contact',
        'source_url' => '#contact',
    ],
    [
        'title' => 'Analytics Admin Dashboard',
        'description' => 'A responsive reporting interface with role-based access, filtered metrics, and export-ready data views.',
        'tags' => ['Blade', 'JavaScript', 'Charts'],
        'media' => 'project-media-dashboard',
        'demo_url' => '#contact',
        'source_url' => '#contact',
    ],
    [
        'title' => 'Service Booking Workflow',
        'description' => 'A scheduling flow with availability rules, customer notifications, admin review, and clean status tracking.',
        'tags' => ['Laravel', 'Notifications', 'Booking'],
        'media' => 'project-media-commerce',
        'demo_url' => '#contact',
        'source_url' => '#contact',
    ],
    [
        'title' => 'Customer Support Portal',
        'description' => 'A secure portal for tickets, attachments, internal notes, and SLA-focused support operations.',
        'tags' => ['PHP', 'Auth', 'MySQL'],
        'media' => 'project-media-api',
        'demo_url' => '#contact',
        'source_url' => '#contact',
    ],
    [
        'title' => 'Performance Review Toolkit',
        'description' => 'A Laravel optimization pass covering query cleanup, indexes, caching boundaries, and slow-page fixes.',
        'tags' => ['Optimization', 'SQL', 'Caching'],
        'media' => 'project-media-dashboard',
        'demo_url' => '#contact',
        'source_url' => '#contact',
    ],
];

Route::get('/', function () use ($projects) {
    return view('welcome', [
        'featuredProjects' => array_slice($projects, 0, 3),
    ]);
})->name('home');

Route::get('/projects', function () use ($projects) {
    $perPage = 3;
    $page = LengthAwarePaginator::resolveCurrentPage();
    $items = array_slice($projects, ($page - 1) * $perPage, $perPage);

    return view('projects.index', [
        'projects' => new LengthAwarePaginator(
            $items,
            count($projects),
            $perPage,
            $page,
            ['path' => route('projects.index')]
        ),
    ]);
})->name('projects.index');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', function (Request $request): RedirectResponse {
        return redirect()->route(
            (bool) $request->session()->get('admin_authenticated', false)
                ? 'admin.dashboard'
                : 'admin.login'
        );
    })->name('index');

    Route::get('/login', function (Request $request): View|RedirectResponse {
        if ((bool) $request->session()->get('admin_authenticated', false)) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    })->name('login');

    Route::post('/login', function (Request $request): RedirectResponse {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $request->session()->regenerate();
        $request->session()->put('admin_authenticated', true);

        return redirect()->route('admin.dashboard');
    })->name('login.store');

    Route::post('/logout', function (Request $request): RedirectResponse {
        $request->session()->forget('admin_authenticated');

        return redirect()->route('admin.login');
    })->name('logout');

    Route::get('/dashboard', function (Request $request): View|RedirectResponse {
        if (! (bool) $request->session()->get('admin_authenticated', false)) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard');
    })->name('dashboard');
});
