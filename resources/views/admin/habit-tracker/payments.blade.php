@extends('admin.layouts.app')
@section('title', 'Habit Tracker Payment Settings')
@section('page-title', 'Habit Tracker')
@section('page-subtitle', 'Payment Settings')
@section('content')
    <h2 class="fs-3 mb-3">Payment Settings</h2>
    <p class="text-secondary mb-5">Enable only payment methods you can receive. Include the account/merchant name, account number, bank branch or routing details, and exact payment steps. Disabled currencies show a purchase inquiry instead.</p>
    @if($errors->any())<div class="alert alert-danger" role="alert">Please correct the highlighted fields.</div>@endif
    <form method="POST" action="{{ route('admin.habit-tracker.payments.update') }}">
        @csrf @method('PUT')
        @foreach (\App\Models\PaymentMethod::OPTIONS as $code => $option)
            <section class="card mb-4"><div class="card-body">
                <h3 class="fs-5">{{ $option['name'] }} · {{ $option['currency'] }}</h3>
                <div class="form-check form-switch mb-3">
                    <input type="hidden" name="methods[{{ $code }}][enabled]" value="0">
                    <input class="form-check-input" type="checkbox" id="{{ $code }}-enabled" name="methods[{{ $code }}][enabled]" value="1" @checked(old('methods.'.$code.'.enabled', $methods->get($code)?->enabled))>
                    <label class="form-check-label" for="{{ $code }}-enabled">Accept payments with this method</label>
                </div>
                <label class="form-label" for="{{ $code }}-instructions">Payment instructions</label>
                <textarea id="{{ $code }}-instructions" name="methods[{{ $code }}][instructions]" rows="6" maxlength="5000" class="form-control @error('methods.'.$code.'.instructions') is-invalid @enderror">{{ old('methods.'.$code.'.instructions', $methods->get($code)?->instructions) }}</textarea>
                @error('methods.'.$code.'.instructions')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div></section>
        @endforeach
        <button class="btn btn-primary" type="submit"><i class="ti ti-device-floppy me-2" aria-hidden="true"></i>Save Payment Settings</button>
    </form>
@endsection
