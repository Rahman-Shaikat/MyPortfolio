<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResumeController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function file(): BinaryFileResponse
    {
        $profile = $this->profileService->currentProfile();
        $resumePath = $profile->resume && Storage::disk('public')->exists($profile->resume)
            ? Storage::disk('public')->path($profile->resume)
            : base_path('docs/Resume - MD. SHAMSUR RAHMAN.pdf');

        abort_unless(is_file($resumePath), 404);

        return response()->file($resumePath, [
            'Content-Disposition' => 'inline; filename="Shamsur-Rahman-Resume.pdf"',
        ]);
    }
}
