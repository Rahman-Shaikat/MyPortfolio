<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
        private readonly SeoService $seoService,
    ) {}

    public function __invoke(): View
    {
        return view('frontend.contact', [
            'profile' => $this->profileService->currentProfile(),
            'seo' => $this->seoService->contact(),
        ]);
    }
}
