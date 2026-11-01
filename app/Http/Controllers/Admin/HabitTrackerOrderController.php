<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateHabitTrackerOrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\HabitTrackerOrderService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HabitTrackerOrderController extends Controller
{
    public function index(Request $request): View
    {
        $search = mb_substr($request->string('search')->trim()->value(), 0, 120);
        $status = in_array($request->query('status'), Order::STATUSES, true) ? $request->query('status') : '';
        $orders = Order::query()->with('detail')
            ->when($status, fn (Builder $query) => $query->where('status', $status))
            ->when($search, function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('reference', 'like', '%'.$search.'%')->orWhere('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%')
                        ->orWhereHas('detail', fn (Builder $detail) => $detail->where('payment_reference', 'like', '%'.$search.'%'));
                });
            })->latest('id')->paginate(15)->withQueryString();
        $fingerprints = $orders->getCollection()->pluck('detail.reference_fingerprint')->filter();
        $repeated = OrderDetail::query()->whereIn('reference_fingerprint', $fingerprints)
            ->select('reference_fingerprint')->groupBy('reference_fingerprint')->havingRaw('COUNT(*) > 1')
            ->pluck('reference_fingerprint')->all();

        return view('admin.habit-tracker.orders.index', compact('orders', 'search', 'status', 'repeated'));
    }

    public function show(Order $order): View
    {
        $order->load(['detail', 'statusHistory']);
        $duplicates = Order::query()->where('id', '!=', $order->id)
            ->whereHas('detail', fn (Builder $query) => $query->where('reference_fingerprint', $order->detail->reference_fingerprint))->get();

        return view('admin.habit-tracker.orders.show', compact('order', 'duplicates'));
    }

    public function update(UpdateHabitTrackerOrderRequest $request, Order $order, HabitTrackerOrderService $service): RedirectResponse
    {
        $service->updateStatus($order, $request->validated());

        return to_route('admin.habit-tracker.orders.show', $order)->with('success', 'Order status saved. No email was sent automatically.');
    }

    public function screenshot(Order $order): StreamedResponse
    {
        $path = $order->detail?->screenshot_path;
        abort_unless($path && Storage::disk('receipts')->exists($path), 404);

        return Storage::disk('receipts')->download($path, 'payment-receipt.'.pathinfo($path, PATHINFO_EXTENSION), [
            'Cache-Control' => 'no-store, private', 'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
