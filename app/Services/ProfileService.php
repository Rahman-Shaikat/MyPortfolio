<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class ProfileService
{
    public function currentProfile(): Profile
    {
        return Profile::query()->first() ?? Profile::make([
            'name' => config('app.name', 'Portfolio'),
            'professional_title' => 'Software Engineer',
            'hero_title_line_one' => 'Software',
            'hero_title_line_two' => 'Engineer',
            'orbit_skills' => [],
            'hero_metrics' => [],
            'about_highlights' => [],
            'skills' => [],
            'services' => [],
            'experiences' => [],
        ]);
    }

    public function storedProfile(): ?Profile
    {
        return Profile::query()->first();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function createProfile(array $attributes, ?UploadedFile $profileImage = null, ?UploadedFile $resume = null): Profile
    {
        if (Profile::query()->exists()) {
            throw ValidationException::withMessages([
                'name' => 'A portfolio profile already exists. Edit the existing profile instead.',
            ]);
        }

        [$profileImagePath, $resumePath] = $this->storeNewFiles($profileImage, $resume);

        if ($profileImagePath) {
            $attributes['profile_image'] = $profileImagePath;
        }

        if ($resumePath) {
            $attributes['resume'] = $resumePath;
        }

        try {
            return Profile::query()->create($attributes);
        } catch (Throwable $exception) {
            $this->deleteFile($profileImagePath);
            $this->deleteFile($resumePath);

            throw $exception;
        }
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function updateProfile(Profile $profile, array $attributes, ?UploadedFile $profileImage = null, ?UploadedFile $resume = null): Profile
    {
        $removeProfileImage = (bool) Arr::pull($attributes, 'remove_profile_image', false);
        $removeResume = (bool) Arr::pull($attributes, 'remove_resume', false);
        $previousProfileImagePath = $profile->profile_image;
        $previousResumePath = $profile->resume;
        [$newProfileImagePath, $newResumePath] = $this->storeNewFiles($profileImage, $resume);

        if ($newProfileImagePath) {
            $attributes['profile_image'] = $newProfileImagePath;
        } elseif ($removeProfileImage) {
            $attributes['profile_image'] = null;
        }

        if ($newResumePath) {
            $attributes['resume'] = $newResumePath;
        } elseif ($removeResume) {
            $attributes['resume'] = null;
        }

        try {
            $profile->update($attributes);
        } catch (Throwable $exception) {
            $this->deleteFile($newProfileImagePath);
            $this->deleteFile($newResumePath);

            throw $exception;
        }

        if (($newProfileImagePath || $removeProfileImage) && $previousProfileImagePath !== $newProfileImagePath) {
            $this->deleteFile($previousProfileImagePath);
        }

        if (($newResumePath || $removeResume) && $previousResumePath !== $newResumePath) {
            $this->deleteFile($previousResumePath);
        }

        return $profile->refresh();
    }

    public function deleteProfile(Profile $profile): void
    {
        $profileImagePath = $profile->profile_image;
        $resumePath = $profile->resume;

        $profile->delete();

        $this->deleteFile($profileImagePath);
        $this->deleteFile($resumePath);
    }

    /**
     * @return array{0: ?string, 1: ?string}
     */
    private function storeNewFiles(?UploadedFile $profileImage, ?UploadedFile $resume): array
    {
        $profileImagePath = $profileImage ? $this->storeFile($profileImage, 'profiles/images') : null;

        try {
            $resumePath = $resume ? $this->storeFile($resume, 'profiles/resumes') : null;
        } catch (Throwable $exception) {
            $this->deleteFile($profileImagePath);

            throw $exception;
        }

        return [$profileImagePath, $resumePath];
    }

    private function storeFile(UploadedFile $file, string $directory): string
    {
        $path = $file->store($directory, 'public');

        if (! $path) {
            throw new RuntimeException('The profile file could not be stored.');
        }

        return $path;
    }

    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
