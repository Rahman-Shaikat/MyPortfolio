<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'publisher' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
            'url' => ['nullable', 'url:http,https', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'status' => ['required', 'boolean'],
        ];
    }
}
