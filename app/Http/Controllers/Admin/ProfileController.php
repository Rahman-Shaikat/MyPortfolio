<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Services\ProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileService $profileService) {}

    public function index(): View
    {
        return view('admin.profiles.index', [
            'profile' => $this->profileService->storedProfile(),
        ]);
    }

    public function create(): View|RedirectResponse
    {
        $profile = $this->profileService->storedProfile();

        if ($profile) {
            return to_route('admin.profiles.edit', $profile);
        }

        return view('admin.profiles.create');
    }

    public function store(StoreProfileRequest $request): RedirectResponse
    {
        $this->profileService->createProfile(
            $request->safe()->except(['profile_image', 'resume']),
            $request->file('profile_image'),
            $request->file('resume'),
        );

        return to_route('admin.profiles.index')
            ->with('success', 'Profile created successfully.');
    }

    public function edit(Profile $profile): View
    {
        return view('admin.profiles.edit', ['profile' => $profile]);
    }

    public function update(UpdateProfileRequest $request, Profile $profile): RedirectResponse
    {
        $this->profileService->updateProfile(
            $profile,
            $request->safe()->except(['profile_image', 'resume']),
            $request->file('profile_image'),
            $request->file('resume'),
        );

        return to_route('admin.profiles.index')
            ->with('success', 'Profile updated successfully.');
    }

    public function destroy(Profile $profile): RedirectResponse
    {
        $this->profileService->deleteProfile($profile);

        return to_route('admin.profiles.index')
            ->with('success', 'Profile deleted successfully.');
    }
}
