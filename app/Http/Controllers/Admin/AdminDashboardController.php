<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Services\PublicationService;
use Illuminate\Contracts\View\View;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService,
        private readonly PublicationService $publicationService,
    ) {}

    public function index(): View
    {
        return view('admin.dashboard', [
            'activeProjectCount' => $this->projectService->activeProjectCount(),
            'publishedPublicationCount' => $this->publicationService->publishedPublicationCount(),
            'featuredProjects' => $this->projectService->featuredProjects(),
        ]);
    }
}
