<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\HabitTrackerPageService;
use App\Services\ProfileService;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

class HabitTrackerController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
        private readonly SeoService $seoService,
        private readonly HabitTrackerPageService $pageService,
    ) {}

    public function __invoke(): View
    {
        $pageInfo = $this->pageService->pageInfo();

        return view('frontend.habit-tracker', [
            'pageInfo' => $pageInfo,
            'prices' => $pageInfo->displayPrices(),
            'profile' => $this->profileService->currentProfile(),
            'seo' => $this->seoService->habitTracker(),
        ]);
    }
}
