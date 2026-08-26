<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
        private readonly SeoService $seoService,
    ) {}

    public function __invoke(): View
    {
        $profile = $this->profileService->currentProfile();

        return view('frontend.about', [
            'profile' => $profile,
            'seo' => $this->seoService->about($profile),
        ]);
    }
}
