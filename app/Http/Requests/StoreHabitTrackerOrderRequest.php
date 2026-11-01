<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHabitTrackerOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['payment_reference' => $this->string('payment_reference')->trim()->value()]);
    }

    public function rules(): array
    {
        $quote = $this->session()->get('habit_quotes.'.$this->string('submission_token')->value(), []);
        $method = $quote['methods'][$this->string('payment_method')->value()] ?? [];

        return [
            'submission_token' => ['required', 'uuid', Rule::in(array_keys($this->session()->get('habit_quotes', [])))],
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40', 'regex:/^[+0-9() .-]{6,40}$/'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'payment_method' => ['required', 'string', Rule::in(array_keys($quote['methods'] ?? []))],
            'payment_reference' => ['required', 'string', 'max:120', 'regex:/[a-zA-Z0-9]/'],
            'bank_sender_name' => [Rule::requiredIf(($method['type'] ?? '') === 'bank'), 'nullable', 'string', 'max:120'],
            'bank_last_four' => ['nullable', 'digits:4'],
            'screenshot' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'max:2048', 'dimensions:max_width=8000,max_height=8000'],
            'website' => ['nullable', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return ['submission_token.in' => 'This form session has expired. Reload the purchase page and submit your existing payment details. Do not pay again.'];
    }
}
