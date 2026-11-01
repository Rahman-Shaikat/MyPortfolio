<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->session()->get('admin_authenticated', false);
    }

    public function rules(): array
    {
        $rules = ['methods' => ['required', 'array:'.implode(',', array_keys(PaymentMethod::OPTIONS))]];
        foreach (PaymentMethod::OPTIONS as $code => $option) {
            $rules['methods.'.$code] = ['required', 'array:enabled,instructions'];
            $rules['methods.'.$code.'.enabled'] = ['required', 'boolean'];
            $rules['methods.'.$code.'.instructions'] = ['required_if:methods.'.$code.'.enabled,1', 'nullable', 'string', 'max:5000'];
        }

        return $rules;
    }
}
