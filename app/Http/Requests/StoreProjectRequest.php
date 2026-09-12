<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', Rule::unique(Project::class, 'slug')],
            'url' => ['nullable', 'url:http,https', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'role' => ['nullable', 'string', 'max:255'],
            'contribution' => ['nullable', 'string', 'max:5000'],
            'challenges' => ['nullable', 'string', 'max:5000'],
            'responsibilities' => ['nullable', 'array', 'max:20'],
            'responsibilities.*' => ['required', 'string', 'max:255'],
            'outcome' => ['nullable', 'string', 'max:5000'],
            'contribution_type' => ['nullable', Rule::in(['creator', 'contributor'])],
            'technologies' => ['nullable', 'array', 'max:20'],
            'technologies.*' => ['required', 'string', 'max:50'],
            'preview_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_personal' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $slug = $this->string('slug')->trim()->value();
        $technologyInput = $this->input('technologies');
        $technologies = is_array($technologyInput)
            ? collect($technologyInput)
            : collect(explode(',', (string) $technologyInput));
        $responsibilityInput = $this->input('responsibilities');
        $responsibilities = is_array($responsibilityInput)
            ? collect($responsibilityInput)
            : collect(explode(',', (string) $responsibilityInput));

        $this->merge([
            'slug' => Str::slug($slug !== '' ? $slug : $this->string('name')->value()),
            'technologies' => $technologies
                ->map(fn (mixed $technology): string => trim((string) $technology))
                ->filter()
                ->unique(fn (string $technology): string => Str::lower($technology))
                ->values()
                ->all(),
            'responsibilities' => $responsibilities
                ->map(fn (mixed $responsibility): string => trim((string) $responsibility))
                ->filter()
                ->unique(fn (string $responsibility): string => Str::lower($responsibility))
                ->values()
                ->all(),
        ]);
    }
}
