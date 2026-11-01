<?php

use App\Models\HabitTrackerPage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use App\Services\HabitTrackerOrderService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

uses(LazilyRefreshDatabase::class);

function purchasePayload(string $token, array $overrides = []): array
{
    return array_merge([
        'submission_token' => $token, 'name' => 'Test Buyer', 'phone' => '+8801712345678',
        'email' => 'buyer@example.com', 'payment_method' => 'bkash_bdt', 'payment_reference' => 'TXN-123',
    ], $overrides);
}

test('purchase pages require configured currency methods and expose no first hundred claim', function () {
    $this->get(route('habit-tracker.purchase', ['currency' => 'BDT']))->assertSuccessful()
        ->assertSee('Payment instructions for BDT are not available yet')->assertDontSee('name="submission_token"', false);
    PaymentMethod::factory()->create();
    $this->get(route('habit-tracker.purchase', ['currency' => 'USD']))->assertSuccessful()
        ->assertSee('Payment instructions for USD are not available yet')->assertSee('Ask about purchasing');
    $this->get(route('habit-tracker'))->assertSuccessful()->assertDontSee('first 100')->assertDontSee('First 100')
        ->assertSee(route('habit-tracker.purchase', ['currency' => 'USD']), false);
});

test('payment settings start disabled and can be configured by admin', function () {
    $this->withSession(['admin_authenticated' => true])->get(route('admin.habit-tracker.payments.edit'))->assertSuccessful();
    $methods = [];
    foreach (PaymentMethod::OPTIONS as $code => $option) {
        $methods[$code] = ['enabled' => $code === 'bkash_bdt' ? '1' : '0', 'instructions' => $code === 'bkash_bdt' ? 'Use the configured merchant payment option.' : ''];
    }
    $this->put(route('admin.habit-tracker.payments.update'), ['methods' => $methods])
        ->assertSessionHasNoErrors()->assertRedirect(route('admin.habit-tracker.payments.edit'));
    expect(PaymentMethod::where('enabled', true)->count())->toBe(1);
    $this->get(route('habit-tracker.purchase'))->assertSee('Use the configured merchant payment option.');
    $methods['bank_usd']['enabled'] = '1';
    $this->put(route('admin.habit-tracker.payments.update'), ['methods' => $methods])
        ->assertSessionHasErrors('methods.bank_usd.instructions');
});

test('submission creates a pending order with quote price and a private screenshot', function () {
    Storage::fake('receipts');
    PaymentMethod::factory()->create();
    $page = HabitTrackerPage::factory()->create();
    $form = $this->get(route('habit-tracker.purchase'))->assertSuccessful();
    $page->update(['bdt_offer_price' => '800']);
    $payload = purchasePayload($form->viewData('token'), [
        'amount' => '1', 'status' => 'completed', 'currency' => 'USD',
        'screenshot' => UploadedFile::fake()->image('receipt.png'),
    ]);
    $this->post(route('habit-tracker.purchase.store'), $payload)->assertSessionHasNoErrors()
        ->assertRedirect(route('habit-tracker.purchase.confirmation'));
    $order = Order::with('detail', 'statusHistory')->sole();
    expect($order->status)->toBe('pending')->and($order->detail->amount)->toBe('500.00')
        ->and($order->detail->currency)->toBe('BDT')->and($order->reference)->toStartWith('HT-')
        ->and($order->completed_at)->toBeNull()->and($order->statusHistory)->toHaveCount(1);
    Storage::disk('receipts')->assertExists($order->detail->screenshot_path);
    $this->get(route('habit-tracker.purchase.confirmation'))->assertSuccessful()
        ->assertSee($order->reference)->assertSee('buyer@example.com')->assertHeader('Cache-Control', 'no-store, private');
});

test('same form cannot create duplicate orders or overwrite an existing submission', function () {
    PaymentMethod::factory()->create();
    $token = $this->get(route('habit-tracker.purchase'))->viewData('token');
    $payload = purchasePayload($token);
    $this->post(route('habit-tracker.purchase.store'), $payload)->assertSessionHasNoErrors();
    $this->post(route('habit-tracker.purchase.store'), $payload)->assertSessionHasNoErrors();
    expect(Order::count())->toBe(1);
    $this->post(route('habit-tracker.purchase.store'), purchasePayload($token, ['email' => 'different@example.com']))
        ->assertSessionHasErrors('submission_token');
    expect(Order::sole()->email)->toBe('buyer@example.com');
});

test('missing session quote cannot create an order', function () {
    $this->post(route('habit-tracker.purchase.store'), purchasePayload((string) Str::uuid()))
        ->assertSessionHasErrors(['submission_token', 'payment_method']);
    expect(Order::count())->toBe(0);
    $this->get(route('habit-tracker.purchase.confirmation'))->assertNotFound();
});

test('validation rejects unsupported methods unsafe files and malformed customer data', function () {
    PaymentMethod::factory()->create();
    $token = $this->get(route('habit-tracker.purchase'))->viewData('token');
    $this->post(route('habit-tracker.purchase.store'), purchasePayload($token, [
        'name' => '', 'phone' => 'invalid-phone', 'email' => 'invalid',
        'payment_method' => 'bank_usd', 'payment_reference' => '',
        'screenshot' => UploadedFile::fake()->create('bad.svg', 10, 'image/svg+xml'), 'website' => 'spam',
    ]))->assertSessionHasErrors(['name', 'phone', 'email', 'payment_method', 'payment_reference', 'screenshot', 'website']);
    expect(Order::count())->toBe(0);
});

test('bank submission requires sender and accepts only four optional account digits', function () {
    PaymentMethod::factory()->create(['code' => 'bank_bdt', 'name' => 'Bank transfer', 'type' => 'bank']);
    $token = $this->get(route('habit-tracker.purchase'))->viewData('token');
    $payload = purchasePayload($token, ['payment_method' => 'bank_bdt', 'bank_last_four' => '123456789']);
    $this->post(route('habit-tracker.purchase.store'), $payload)->assertSessionHasErrors(['bank_sender_name', 'bank_last_four']);
    $this->post(route('habit-tracker.purchase.store'), array_merge($payload, ['bank_sender_name' => 'Test Buyer', 'bank_last_four' => '0123']))
        ->assertSessionHasNoErrors();
    expect(Order::sole()->detail->bank_last_four)->toBe('0123');
});

test('admin can filter inspect fulfill cancel and reopen an order with audit history', function () {
    PaymentMethod::factory()->create();
    $token = $this->get(route('habit-tracker.purchase'))->viewData('token');
    $this->post(route('habit-tracker.purchase.store'), purchasePayload($token));
    $order = Order::sole();
    $this->withSession(['admin_authenticated' => true])->get(route('admin.habit-tracker.orders.index', ['search' => 'TXN-123', 'status' => 'pending']))
        ->assertSuccessful()->assertSee($order->reference);
    $this->get(route('admin.habit-tracker.orders.index', ['status' => 'completed']))->assertDontSee($order->reference);
    $this->get(route('admin.habit-tracker.orders.show', $order))->assertSuccessful()->assertSee('Customer &amp; Payment', false);
    $url = route('admin.habit-tracker.orders.update', $order);
    $this->patch($url, ['status' => 'completed', 'expected_status' => 'pending'])->assertSessionHasErrors('delivery_confirmed');
    $this->patch($url, ['status' => 'completed', 'expected_status' => 'pending', 'delivery_confirmed' => '1'])->assertSessionHasNoErrors();
    expect($order->refresh()->completed_at)->not->toBeNull();
    $this->patch($url, ['status' => 'completed', 'expected_status' => 'pending', 'delivery_confirmed' => '1'])->assertSessionHasNoErrors();
    expect($order->statusHistory()->count())->toBe(2);
    $this->patch($url, ['status' => 'pending', 'expected_status' => 'pending'])->assertSessionHasErrors('status');
    $this->patch($url, ['status' => 'cancelled', 'expected_status' => 'completed'])->assertSessionHasErrors('reason');
    $this->patch($url, ['status' => 'cancelled', 'expected_status' => 'completed', 'reason' => 'Payment reversed'])->assertSessionHasNoErrors();
    expect($order->refresh()->cancelled_at)->not->toBeNull()->and($order->completed_at)->toBeNull();
    $this->patch($url, ['status' => 'pending', 'expected_status' => 'cancelled', 'reason' => 'Review reopened'])->assertSessionHasNoErrors();
    expect($order->refresh()->status)->toBe('pending')->and($order->statusHistory()->count())->toBe(4);
});

test('repeated normalized payment references are flagged without discarding customer submissions', function () {
    PaymentMethod::factory()->create();
    foreach (['TXN-123', 'txn123'] as $reference) {
        $token = $this->get(route('habit-tracker.purchase'))->viewData('token');
        $this->post(route('habit-tracker.purchase.store'), purchasePayload($token, ['payment_reference' => $reference]))->assertSessionHasNoErrors();
    }
    expect(Order::count())->toBe(2)->and(Order::pluck('reference')->unique())->toHaveCount(2);
    $this->withSession(['admin_authenticated' => true])->get(route('admin.habit-tracker.orders.index'))->assertSee('Repeated reference');
    $this->get(route('admin.habit-tracker.orders.show', Order::first()))->assertSee('Repeated payment reference.');
});

test('guests cannot access orders payment settings mutations or screenshots', function () {
    $order = Order::factory()->create();
    foreach (['admin.habit-tracker.orders.index', 'admin.habit-tracker.payments.edit'] as $route) {
        $this->get(route($route))->assertNotFound();
    }
    $this->get(route('admin.habit-tracker.orders.show', $order))->assertNotFound();
    $this->get(route('admin.habit-tracker.orders.screenshot', $order))->assertNotFound();
    $this->patch(route('admin.habit-tracker.orders.update', $order), ['status' => 'completed'])->assertNotFound();
    $this->put(route('admin.habit-tracker.payments.update'), [])->assertNotFound();
});

test('screenshots are only downloadable by admin and oversized uploads are rejected', function () {
    Storage::fake('receipts');
    PaymentMethod::factory()->create();
    $token = $this->get(route('habit-tracker.purchase'))->viewData('token');
    $this->post(route('habit-tracker.purchase.store'), purchasePayload($token, ['screenshot' => UploadedFile::fake()->image('large.jpg')->size(2049)]))
        ->assertSessionHasErrors('screenshot');
    $this->post(route('habit-tracker.purchase.store'), purchasePayload($token, ['screenshot' => UploadedFile::fake()->image('valid.jpg')]))
        ->assertSessionHasNoErrors();
    $order = Order::sole();
    $this->get(route('admin.habit-tracker.orders.screenshot', $order))->assertNotFound();
    $this->withSession(['admin_authenticated' => true])->get(route('admin.habit-tracker.orders.screenshot', $order))
        ->assertSuccessful()->assertDownload('payment-receipt.jpg')->assertHeader('X-Content-Type-Options', 'nosniff');
});

test('usd checkout uses configured usd price and method', function () {
    PaymentMethod::factory()->create(['code' => 'bank_usd', 'name' => 'International bank transfer', 'type' => 'bank', 'currency' => 'USD']);
    $form = $this->get(route('habit-tracker.purchase', ['currency' => 'USD']))->assertSee('USD 5.00');
    $this->post(route('habit-tracker.purchase.store'), purchasePayload($form->viewData('token'), [
        'payment_method' => 'bank_usd', 'bank_sender_name' => 'Test Buyer',
    ]))->assertSessionHasNoErrors();
    expect(Order::sole()->detail->currency)->toBe('USD')->and(Order::sole()->detail->amount)->toBe('5.00');
});

test('a quote from another session cannot be submitted', function () {
    PaymentMethod::factory()->create();
    $token = $this->get(route('habit-tracker.purchase'))->viewData('token');
    $this->flushSession();
    $this->post(route('habit-tracker.purchase.store'), purchasePayload($token))->assertSessionHasErrors('submission_token');
    expect(Order::count())->toBe(0);
});

test('submission rate limiting blocks repeated requests', function () {
    for ($attempt = 0; $attempt < 6; $attempt++) {
        $this->post(route('habit-tracker.purchase.store'), [])->assertRedirect();
    }
    $this->post(route('habit-tracker.purchase.store'), [])->assertStatus(429);
});

test('a failed order write removes uploaded screenshot and rolls back the order', function () {
    Storage::fake('receipts');
    $method = PaymentMethod::factory()->create();
    $quote = ['amount' => '500.00', 'currency' => 'BDT', 'methods' => ['bkash_bdt' => $method->only(['name', 'type', 'instructions'])]];
    $listener = static function (): void {
        throw new RuntimeException('Simulated database write failure');
    };
    Event::listen('eloquent.creating: '.OrderDetail::class, $listener);
    try {
        expect(fn () => app(HabitTrackerOrderService::class)->submit(purchasePayload((string) Str::uuid(), [
            'screenshot' => UploadedFile::fake()->image('receipt.png'),
        ]), $quote))->toThrow(RuntimeException::class);
    } finally {
        Event::forget('eloquent.creating: '.OrderDetail::class);
    }
    expect(Order::count())->toBe(0)->and(Storage::disk('receipts')->allFiles())->toBe([]);
});
