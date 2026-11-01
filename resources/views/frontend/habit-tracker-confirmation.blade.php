<x-frontend::layout :profile="$profile" :seo="$seo" :page-styles="['resources/css/habit-tracker.css']">
    <section class="habit-page habit-checkout">
        <div class="habit-container habit-order-confirmation">
            <p class="habit-product-name">Habit Tracker for Windows</p>
            <h1>Payment details received.</h1>
            <p>Thank you, {{ $order->name }}. We will manually verify your payment and email the app to <strong>{{ $order->email }}</strong> once it is confirmed.</p>
            <dl><dt>Order reference</dt><dd>{{ $order->reference }}</dd><dt>Status</dt><dd>{{ ucfirst($order->status) }}</dd></dl>
            <p>Keep this reference for any questions about your order. Please do not submit the same payment again.</p>
            <a class="habit-button habit-button-primary" href="{{ route('habit-tracker') }}">Back to Habit Tracker</a>
        </div>
    </section>
</x-frontend::layout>
