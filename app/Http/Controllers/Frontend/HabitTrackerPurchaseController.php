<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHabitTrackerOrderRequest;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Services\HabitTrackerOrderService;
use App\Services\HabitTrackerPageService;
use App\Services\ProfileService;
use App\Services\SeoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class HabitTrackerPurchaseController extends Controller
{
    public function __construct(
        private readonly HabitTrackerPageService $pages,
        private readonly HabitTrackerOrderService $orders,
        private readonly ProfileService $profiles,
        private readonly SeoService $seo,
    ) {}

    public function create(Request $request): Response
    {
        $currency = $request->query('currency') === 'USD' ? 'USD' : 'BDT';
        $oldToken = $request->session()->getOldInput('submission_token');
        $quotes = $request->session()->get('habit_quotes', []);
        $quote = is_string($oldToken) ? ($quotes[$oldToken] ?? null) : null;
        $token = $quote ? $oldToken : Str::uuid()->toString();
        if (! $quote) {
            $methods = PaymentMethod::query()->where('enabled', true)->where('currency', $currency)
                ->whereNotNull('instructions')->where('instructions', '!=', '')->get()->keyBy('code')
                ->map(fn (PaymentMethod $method): array => $method->only(['name', 'type', 'instructions']))->all();
            $quote = ['currency' => $currency, 'amount' => $this->pages->pageInfo()->getAttribute(strtolower($currency).'_offer_price'), 'methods' => $methods];
            if ($methods !== []) {
                $quotes[$token] = $quote;
                $request->session()->put('habit_quotes', array_slice($quotes, -20, null, true));
            }
        }

        return $this->page('frontend.habit-tracker-purchase', [
            'quote' => $quote, 'token' => $token,
        ], 'Purchase Habit Tracker');
    }

    public function store(StoreHabitTrackerOrderRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $order = $this->orders->submit($data, $request->session()->get('habit_quotes.'.$data['submission_token']));
        $request->session()->put('habit_order_confirmation', $order->id);

        return to_route('habit-tracker.purchase.confirmation')->withHeaders(['Cache-Control' => 'no-store, private']);
    }

    public function confirmation(Request $request): Response
    {
        $order = Order::query()->findOrFail($request->session()->get('habit_order_confirmation'));

        return $this->page('frontend.habit-tracker-confirmation', ['order' => $order], 'Payment Submitted');
    }

    /** @param array<string, mixed> $data */
    private function page(string $view, array $data, string $title): Response
    {
        $seo = array_replace($this->seo->habitTracker(), [
            'title' => $title.' | Habit Tracker', 'robots' => 'noindex,nofollow,noarchive',
            'canonical' => route('habit-tracker.purchase'), 'structuredData' => [],
        ]);

        return response()->view($view, $data + ['profile' => $this->profiles->currentProfile(), 'seo' => $seo])
            ->header('Cache-Control', 'no-store, private')->header('Referrer-Policy', 'same-origin');
    }
}
