<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use App\Services\ProjectService;
use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService,
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        return view('frontend.projects.index', [
            'projects' => $this->projectService->paginatedProjects(),
            'profile' => $this->profileService->currentProfile(),
        ]);
    }
}
