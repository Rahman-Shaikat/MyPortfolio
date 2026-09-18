<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendContactRequest;
use App\Mail\ContactInquiryMail;
use App\Services\ProfileService;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
        private readonly SeoService $seoService,
    ) {}

    public function index(): View
    {
        return view('frontend.contact', [
            'profile' => $this->profileService->currentProfile(),
            'seo' => $this->seoService->contact(),
        ]);
    }

    public function store(SendContactRequest $request): RedirectResponse
    {
        $profile = $this->profileService->currentProfile();

        abort_unless($profile->email, 503, 'Contact email is not configured.');

        $validated = $request->validated();

        Mail::to($profile->email)->send(new ContactInquiryMail(
            senderName: $validated['name'],
            senderEmail: $validated['email'],
            projectType: $validated['project_type'],
            inquiryMessage: $validated['message'],
        ));

        return back()->with('contact_success', 'Your inquiry has been sent successfully.');
    }
}
