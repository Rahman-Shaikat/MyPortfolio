@extends('admin.layouts.app')
@section('title', 'Order '.$order->reference)
@section('page-title', 'Habit Tracker Order')
@section('page-subtitle', $order->reference)
@section('content')
    <a class="btn btn-white mb-4" href="{{ route('admin.habit-tracker.orders.index') }}"><i class="ti ti-arrow-left me-2" aria-hidden="true"></i>Orders</a>
    @if($duplicates->isNotEmpty())
        <div class="alert alert-warning" role="alert"><strong>Repeated payment reference.</strong> Check these orders before fulfilling this payment:
            @foreach($duplicates as $duplicate)<a class="d-block" href="{{ route('admin.habit-tracker.orders.show', $duplicate) }}">{{ $duplicate->reference }} ({{ $duplicate->status }})</a>@endforeach
        </div>
    @endif
    <div class="row g-4">
        <div class="col-lg-7">
            <section class="card mb-4"><div class="card-body">
                <h2 class="fs-4">Customer &amp; Payment</h2>
                <dl class="row mb-0 text-break">
                    @foreach(['Customer' => $order->name, 'Email' => $order->email, 'Phone' => $order->phone, 'Product' => $order->detail->product, 'Amount' => $order->detail->currency.' '.$order->detail->amount, 'Method' => $order->detail->payment_method_name, 'Transaction reference' => $order->detail->payment_reference, 'Bank sender' => $order->detail->bank_sender_name, 'Last four digits' => $order->detail->bank_last_four] as $label => $value)
                        @if($value)<dt class="col-sm-4 mb-2">{{ $label }}</dt><dd class="col-sm-8">{{ $value }}</dd>@endif
                    @endforeach
                </dl>
                <h3 class="fs-6 mt-3">Payment instructions shown to customer</h3>
                <p class="text-break">{!! nl2br(e($order->detail->payment_instructions)) !!}</p>
                @if($order->detail->screenshot_path)<a class="btn btn-white" href="{{ route('admin.habit-tracker.orders.screenshot', $order) }}"><i class="ti ti-download me-2" aria-hidden="true"></i>Download Private Screenshot</a>@else<p class="text-secondary mb-0">No screenshot submitted.</p>@endif
            </div></section>
            <section class="card"><div class="card-body">
                <h2 class="fs-4">Status History</h2>
                <ul class="list-unstyled mb-0">
                    @foreach($order->statusHistory as $entry)
                        <li class="border-bottom py-3">
                            <strong>{{ $entry->from_status ? ucfirst($entry->from_status).' → ' : '' }}{{ ucfirst($entry->to_status) }}</strong>
                            <small class="d-block text-secondary">{{ $entry->created_at->format('d M Y H:i') }} · {{ $entry->actor }}</small>
                            @if($entry->reason)<p class="mb-0 mt-2 text-break">{{ $entry->reason }}</p>@endif
                        </li>
                    @endforeach
                </ul>
            </div></section>
        </div>
        <div class="col-lg-5">
            <section class="card"><div class="card-body">
                <h2 class="fs-4">Update Status</h2>
                <p>Verify the payment in your bank/bKash records, then email the installer or download link manually. Mark completed only after delivery.</p>
                @if($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <form method="POST" action="{{ route('admin.habit-tracker.orders.update', $order) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="expected_status" value="{{ $order->status }}">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select mb-3">@foreach(\App\Models\Order::STATUSES as $status)<option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ ucfirst($status) }}</option>@endforeach</select>
                    <label class="form-label" for="reason">Internal reason / note</label>
                    <textarea id="reason" name="reason" class="form-control" rows="4" maxlength="2000">{{ old('reason') }}</textarea>
                    <p class="form-text">A reason is required when cancelling. It is not shown to customers.</p>
                    <div class="form-check my-4"><input id="delivered" type="checkbox" name="delivery_confirmed" value="1" class="form-check-input" @checked(old('delivery_confirmed'))><label for="delivered" class="form-check-label">I verified the payment and manually emailed the app to the customer (required to complete).</label></div>
                    <button class="btn btn-primary" type="submit"><i class="ti ti-device-floppy me-2" aria-hidden="true"></i>Save Status</button>
                </form>
            </div></section>
        </div>
    </div>
@endsection
