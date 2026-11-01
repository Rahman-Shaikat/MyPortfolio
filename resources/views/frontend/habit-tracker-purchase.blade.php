<x-frontend::layout :profile="$profile" :seo="$seo" :page-styles="['resources/css/habit-tracker.css']">
    <section class="habit-page habit-checkout">
        <div class="habit-container">
            <a class="habit-checkout-back" href="{{ route('habit-tracker') }}">Back to Habit Tracker</a>
            <header class="habit-checkout-heading">
                <p class="habit-product-name">Habit Tracker for Windows</p>
                <h1>Make room for better habits.</h1>
                <p>Pay manually, share your payment details, and we will verify your payment before emailing your app.</p>
            </header>
            <nav class="habit-checkout-regions" aria-label="Purchase currency">
                <a href="{{ route('habit-tracker.purchase', ['currency' => 'BDT']) }}" @if($quote['currency'] === 'BDT') aria-current="page" @endif>Bangladesh · BDT</a>
                <a href="{{ route('habit-tracker.purchase', ['currency' => 'USD']) }}" @if($quote['currency'] === 'USD') aria-current="page" @endif>International · USD</a>
            </nav>
            <div class="habit-checkout-total"><span>One-time payment. No subscription.</span><strong>{{ $quote['currency'] }} {{ number_format((float) $quote['amount'], 2) }}</strong></div>

            @if ($quote['methods'] === [])
                <section class="habit-checkout-notice">
                    <h2>Let us help with your purchase.</h2>
                    <p>Payment instructions for {{ $quote['currency'] }} are not available yet. Contact us before making a payment.</p>
                    <a class="habit-button habit-button-primary" href="{{ route('contact', ['interest' => 'habit-tracker']) }}">Ask about purchasing</a>
                </section>
            @else
                <section class="habit-payment-instructions" aria-labelledby="payment-instructions-title">
                    <h2 id="payment-instructions-title"><span>01</span> Make your payment</h2>
                    <p>Use one of the methods below to pay the amount shown above. Keep your transaction reference. Do not send your PIN, password, or OTP.</p>
                    <div class="habit-payment-methods">
                        @foreach ($quote['methods'] as $code => $method)
                            <article><h3>{{ $method['name'] }}</h3><p class="habit-payment-instruction-text">{{ $method['instructions'] }}</p></article>
                        @endforeach
                    </div>
                </section>
                <section class="habit-payment-submission" aria-labelledby="payment-form-title">
                    <h2 id="payment-form-title"><span>02</span> Share your payment details</h2>
                    <p>Already paid? Submit your existing transaction details below. You do not need to pay again if you correct this form.</p>
                    @if ($errors->any())
                        <div class="habit-form-errors" role="alert">
                            <strong>Please check your submission.</strong>
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                            @if ($errors->has('submission_token'))<a href="{{ route('habit-tracker.purchase', ['currency' => $quote['currency']]) }}">Reload the purchase form</a>@endif
                            <p>If you selected a screenshot, please select it again.</p>
                        </div>
                    @endif
                    <form class="habit-checkout-form" action="{{ route('habit-tracker.purchase.store') }}" method="POST" enctype="multipart/form-data" data-habit-order-form>
                        @csrf
                        <input type="hidden" name="submission_token" value="{{ $token }}">
                        <div class="contact-honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                        <div class="habit-form-grid">
                            <label for="purchase-name">Full name<input id="purchase-name" name="name" autocomplete="name" required maxlength="120" value="{{ old('name') }}" @error('name') aria-invalid="true" @enderror></label>
                            <label for="purchase-phone">Phone number<input id="purchase-phone" name="phone" type="tel" autocomplete="tel" required maxlength="40" value="{{ old('phone') }}" @error('phone') aria-invalid="true" @enderror></label>
                            <label for="purchase-email">Delivery email<input id="purchase-email" name="email" type="email" autocomplete="email" required maxlength="255" value="{{ old('email') }}" @error('email') aria-invalid="true" @enderror><small>Your app will be sent to this address after verification.</small></label>
                            <label for="purchase-method">Payment method<select id="purchase-method" name="payment_method" required data-payment-method>
                                <option value="">Select the method you used</option>
                                @foreach ($quote['methods'] as $code => $method)
                                    <option value="{{ $code }}" data-type="{{ $method['type'] }}" @selected(old('payment_method') === $code)>{{ $method['name'] }}</option>
                                @endforeach
                            </select></label>
                            <label for="purchase-reference">Transaction ID / bank payment reference<input id="purchase-reference" name="payment_reference" required maxlength="120" value="{{ old('payment_reference') }}" @error('payment_reference') aria-invalid="true" @enderror></label>
                        </div>
                        <div class="habit-form-grid" data-bank-fields>
                            <label for="bank-sender">Bank sender / account-holder name<input id="bank-sender" name="bank_sender_name" maxlength="120" value="{{ old('bank_sender_name') }}"><small>Required for bank transfers only.</small></label>
                            <label for="bank-digits">Last four account digits (optional)<input id="bank-digits" name="bank_last_four" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" value="{{ old('bank_last_four') }}"></label>
                        </div>
                        <label for="purchase-screenshot">Payment screenshot (optional)<input id="purchase-screenshot" name="screenshot" type="file" accept=".jpg,.jpeg,.png,.webp"><small>JPG, PNG or WebP, up to 2 MB. Hide unrelated balances and transactions.</small></label>
                        <p class="habit-checkout-privacy">Your details are used to verify this payment and deliver your app. Screenshots are visible only to the administrator.</p>
                        <button class="habit-button habit-button-primary" type="submit" data-order-submit>Submit payment details</button>
                        <p class="habit-checkout-footnote">Manual verification is required. Submission does not mean that payment has been confirmed.</p>
                    </form>
                </section>
            @endif
        </div>
    </section>
</x-frontend::layout>
