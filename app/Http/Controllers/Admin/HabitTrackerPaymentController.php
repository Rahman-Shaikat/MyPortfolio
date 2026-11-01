<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePaymentSettingsRequest;
use App\Models\PaymentMethod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class HabitTrackerPaymentController extends Controller
{
    public function edit(): View
    {
        return view('admin.habit-tracker.payments', ['methods' => PaymentMethod::query()->get()->keyBy('code')]);
    }

    public function update(UpdatePaymentSettingsRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            foreach (PaymentMethod::OPTIONS as $code => $option) {
                PaymentMethod::query()->updateOrCreate(['code' => $code], $option + $request->validated('methods.'.$code));
            }
        });

        return to_route('admin.habit-tracker.payments.edit')->with('success', 'Payment instructions saved.');
    }
}
