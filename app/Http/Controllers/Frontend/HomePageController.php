<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use App\Services\ProjectService;
use App\Services\PublicationService;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

class HomePageController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService,
        private readonly ProfileService $profileService,
        private readonly PublicationService $publicationService,
        private readonly SeoService $seoService,
    ) {}

    public function index(): View
    {
        $profile = $this->profileService->currentProfile();

        return view('frontend.home', [
            'featuredProjects' => $this->projectService->featuredProjects(6),
            'featuredPublications' => $this->publicationService->featuredPublications(),
            'profile' => $profile,
            'seo' => $this->seoService->home($profile),
        ]);
    }
}
