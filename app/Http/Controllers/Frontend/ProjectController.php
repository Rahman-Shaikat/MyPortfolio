<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use App\Services\ProjectService;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService,
        private readonly ProfileService $profileService,
        private readonly SeoService $seoService,
    ) {}

    public function index(): View
    {
        $profile = $this->profileService->currentProfile();
        $projects = $this->projectService->paginatedProjects();

        return view('frontend.projects.index', [
            'projects' => $projects,
            'profile' => $profile,
            'seo' => $this->seoService->projects($profile, $projects->currentPage()),
        ]);
    }

    public function show(string $slug): View
    {
        $project = $this->projectService->activeProjectBySlug($slug);

        return view('frontend.projects.show', [
            'profile' => $this->profileService->currentProfile(),
            'project' => $project,
            'relatedProjects' => $this->projectService->relatedProjects($project),
            'seo' => $this->seoService->project($project),
        ]);
    }
}
