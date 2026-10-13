<?php

namespace App\Http\Requests;

use App\Models\HabitTrackerPage;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHabitTrackerPageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->session()->get('admin_authenticated', false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $rules = [
            'video_url' => ['bail', 'required', 'string', 'url:https', 'max:2048', function (string $attribute, mixed $value, Closure $fail): void {
                if (HabitTrackerPage::youtubeId($value) === null) {
                    $fail('Enter a valid YouTube video URL (watch, share, shorts, or embed link).');
                }
            }],
        ];
        foreach (['usd', 'bdt'] as $currency) {
            $rules[$currency.'_regular_price'] = ['required', 'numeric', 'decimal:0,2', 'min:0.01', 'max:999999.99'];
            $rules[$currency.'_offer_price'] = ['required', 'numeric', 'decimal:0,2', 'min:0.01', 'max:999999.99', 'lte:'.$currency.'_regular_price'];
        }
        foreach (HabitTrackerPage::IMAGE_FIELDS as $field => $label) {
            $rules[$field] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'max:2048', 'dimensions:max_width=8000,max_height=8000'];
            $rules['remove_'.$field] = ['sometimes', 'boolean'];
        }

        return $rules;
    }
}
