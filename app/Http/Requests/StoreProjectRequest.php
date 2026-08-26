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
            'technologies' => ['nullable', 'array', 'max:20'],
            'technologies.*' => ['required', 'string', 'max:50'],
            'preview_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_personal' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:4294967295'],
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

        $this->merge([
            'slug' => Str::slug($slug !== '' ? $slug : $this->string('name')->value()),
            'technologies' => $technologies
                ->map(fn (mixed $technology): string => trim((string) $technology))
                ->filter()
                ->unique(fn (string $technology): string => Str::lower($technology))
                ->values()
                ->all(),
        ]);
    }
}
