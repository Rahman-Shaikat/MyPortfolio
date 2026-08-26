<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->session()->get('admin_authenticated', false);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'brand_initials' => ['nullable', 'string', 'max:3'],
            'professional_title' => ['required', 'string', 'max:255'],
            'header_subtitle' => ['nullable', 'string', 'max:255'],
            'availability_text' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'hero_title_line_one' => ['nullable', 'string', 'max:255'],
            'hero_title_line_two' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string', 'max:2000'],
            'profile_caption' => ['nullable', 'string', 'max:500'],
            'current_focus' => ['nullable', 'string', 'max:255'],
            'core_strengths' => ['nullable', 'string', 'max:255'],
            'orbit_skills' => ['nullable', 'array', 'max:12'],
            'orbit_skills.*' => ['required', 'string', 'max:50'],
            'hero_metrics' => ['nullable', 'array', 'max:6'],
            'hero_metrics.*.value' => ['required', 'string', 'max:50'],
            'hero_metrics.*.label' => ['required', 'string', 'max:255'],
            'about_title' => ['nullable', 'string', 'max:1000'],
            'about_paragraph_one' => ['nullable', 'string', 'max:3000'],
            'about_paragraph_two' => ['nullable', 'string', 'max:3000'],
            'about_highlights' => ['nullable', 'array', 'max:8'],
            'about_highlights.*.title' => ['required', 'string', 'max:255'],
            'about_highlights.*.description' => ['required', 'string', 'max:1000'],
            'skills_title' => ['nullable', 'string', 'max:1000'],
            'skills' => ['nullable', 'array', 'max:50'],
            'skills.*' => ['required', 'string', 'max:50'],
            'services_title' => ['nullable', 'string', 'max:1000'],
            'services' => ['nullable', 'array', 'max:16'],
            'services.*.title' => ['required', 'string', 'max:255'],
            'services.*.description' => ['required', 'string', 'max:1500'],
            'projects_title' => ['nullable', 'string', 'max:1000'],
            'experience_title' => ['nullable', 'string', 'max:1000'],
            'experiences' => ['nullable', 'array', 'max:16'],
            'experiences.*.period' => ['required', 'string', 'max:100'],
            'experiences.*.title' => ['required', 'string', 'max:255'],
            'experiences.*.description' => ['required', 'string', 'max:1500'],
            'contact_title' => ['nullable', 'string', 'max:1000'],
            'contact_description' => ['nullable', 'string', 'max:2000'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:255'],
            'github_url' => ['nullable', 'url:http,https', 'max:255'],
            'linkedin_url' => ['nullable', 'url:http,https', 'max:255'],
            'x_url' => ['nullable', 'url:http,https', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'resume' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'remove_profile_image' => ['nullable', 'boolean'],
            'remove_resume' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'skills' => $this->normalizeCommaSeparatedValues($this->input('skills')),
            'orbit_skills' => $this->normalizeCommaSeparatedValues($this->input('orbit_skills')),
            'hero_metrics' => $this->normalizeItems($this->input('hero_metrics'), ['value', 'label']),
            'about_highlights' => $this->normalizeItems($this->input('about_highlights'), ['title', 'description']),
            'services' => $this->normalizeItems($this->input('services'), ['title', 'description']),
            'experiences' => $this->normalizeItems($this->input('experiences'), ['period', 'title', 'description']),
        ]);
    }

    /**
     * @return array<int, string>
     */
    private function normalizeCommaSeparatedValues(mixed $input): array
    {
        $values = is_array($input) ? collect($input) : collect(explode(',', (string) $input));

        return $values
            ->map(fn (mixed $value): string => trim((string) $value))
            ->filter()
            ->unique(fn (string $value): string => Str::lower($value))
            ->values()
            ->all();
    }

    /**
     * @param  array<int, string>  $keys
     * @return array<int, array<string, string>>
     */
    private function normalizeItems(mixed $input, array $keys): array
    {
        if (! is_array($input)) {
            return [];
        }

        return collect($input)
            ->map(function (mixed $item) use ($keys): array {
                $item = is_array($item) ? $item : [];

                return collect($keys)
                    ->mapWithKeys(fn (string $key): array => [$key => trim((string) ($item[$key] ?? ''))])
                    ->all();
            })
            ->filter(fn (array $item): bool => collect($item)->contains(fn (string $value): bool => $value !== ''))
            ->values()
            ->all();
    }
}
