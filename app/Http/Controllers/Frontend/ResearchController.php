<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use App\Services\PublicationService;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

class ResearchController extends Controller
{
    public function __construct(
        private readonly PublicationService $publicationService,
        private readonly ProfileService $profileService,
        private readonly SeoService $seoService,
    ) {}

    public function index(): View
    {
        $profile = $this->profileService->currentProfile();

        return view('frontend.research.index', [
            'profile' => $profile,
            'publications' => $this->publicationService->publishedPublications(),
            'seo' => $this->seoService->research($profile),
        ]);
    }

    public function show(string $slug): View
    {
        $publication = $this->publicationService->publishedPublicationBySlug($slug);

        return view('frontend.research.show', [
            'profile' => $this->profileService->currentProfile(),
            'publication' => $publication,
            'seo' => $this->seoService->publication($publication),
        ]);
    }
}
