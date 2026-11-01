<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHabitTrackerOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->session()->get('admin_authenticated', false);
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(Order::STATUSES)],
            'expected_status' => ['required', Rule::in(Order::STATUSES)],
            'reason' => ['required_if:status,cancelled', 'nullable', 'string', 'max:2000'],
            'delivery_confirmed' => ['required_if:status,completed', 'accepted_if:status,completed'],
        ];
    }
}
