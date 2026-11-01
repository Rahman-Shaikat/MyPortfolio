@extends('admin.layouts.app')
@section('title', 'Habit Tracker Orders')
@section('page-title', 'Habit Tracker')
@section('page-subtitle', 'Orders')
@section('content')
    <h2 class="fs-3 mb-4">Orders</h2>
    <form class="row g-3 mb-4" method="GET">
        <div class="col-md-6"><label class="visually-hidden" for="order-search">Search orders</label><input id="order-search" class="form-control" name="search" maxlength="120" value="{{ $search }}" placeholder="Reference, name, email, phone or transaction"></div>
        <div class="col-md-3"><label class="visually-hidden" for="order-status">Status</label><select id="order-status" class="form-select" name="status"><option value="">All statuses</option>@foreach(\App\Models\Order::STATUSES as $value)<option value="{{ $value }}" @selected($status === $value)>{{ ucfirst($value) }}</option>@endforeach</select></div>
        <div class="col-md-3 d-flex gap-2"><button class="btn btn-primary" type="submit"><i class="ti ti-search me-2" aria-hidden="true"></i>Filter</button><a class="btn btn-white" href="{{ route('admin.habit-tracker.orders.index') }}">Clear</a></div>
    </form>
    <div class="card"><div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Order</th><th>Customer</th><th>Amount</th><th>Payment</th><th>Status</th><th>Submitted</th><th></th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><a href="{{ route('admin.habit-tracker.orders.show', $order) }}">{{ $order->reference }}</a></td>
                        <td>{{ $order->name }}<small class="d-block text-secondary">{{ $order->email }}</small></td>
                        <td class="text-nowrap">{{ $order->detail?->currency }} {{ $order->detail?->amount }}</td>
                        <td>{{ $order->detail?->payment_method_name }}<small class="d-block">{{ $order->detail?->payment_reference }}</small>
                            @if(in_array($order->detail?->reference_fingerprint, $repeated, true))<span class="badge bg-warning text-dark">Repeated reference</span>@endif
                        </td>
                        <td><span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="text-nowrap">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td><a class="btn btn-white btn-icon btn-sm" href="{{ route('admin.habit-tracker.orders.show', $order) }}" aria-label="View order {{ $order->reference }}" title="View order"><i class="ti ti-eye"></i></a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-6">No orders match these filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>@if($orders->hasPages())<div class="card-body border-top">{{ $orders->links() }}</div>@endif</div>
@endsection
