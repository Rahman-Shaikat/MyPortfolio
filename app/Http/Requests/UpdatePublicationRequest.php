<?php

namespace App\Http\Requests;

use App\Models\Publication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdatePublicationRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Publication::class, 'slug')->ignore($this->route('publication')),
            ],
            'authors' => ['nullable', 'array', 'max:20'],
            'authors.*' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
            'url' => ['nullable', 'url:http,https', 'max:255'],
            'reference_url' => ['nullable', 'url:http,https', 'max:255'],
            'research_topics' => ['nullable', 'array', 'max:20'],
            'research_topics.*' => ['required', 'string', 'max:100'],
            'contribution' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'status' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $slug = $this->string('slug')->trim()->value();

        $this->merge([
            'slug' => Str::slug($slug !== '' ? $slug : $this->string('title')->value()),
            'authors' => $this->normalizeCommaSeparatedValues($this->input('authors')),
            'research_topics' => $this->normalizeCommaSeparatedValues($this->input('research_topics')),
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
}
