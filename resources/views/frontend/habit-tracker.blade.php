<x-frontend::layout :profile="$profile" :seo="$seo" :page-styles="['resources/css/habit-tracker.css']">
    <article class="habit-page" data-habit-pricing data-prices="{{ json_encode($prices) }}">
        <section class="habit-hero" aria-labelledby="habit-hero-title">
            <div class="habit-container habit-hero-copy">
                <p class="habit-product-name">Habit Tracker</p>
                <h1 id="habit-hero-title"><span>Build the routines</span><span>that build your life.</span></h1>
                <p class="habit-hero-lede">Read a little. Move a little. Make time for what matters. Turn your daily intentions into a month of visible progress.</p>
                <div class="habit-actions">
                    <a class="habit-button habit-button-primary" href="#purchase">
                        Purchase for Windows
                        <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M10 5l5 5-5 5"/></svg>
                    </a>
                    <a class="habit-button habit-button-secondary" href="#features">Explore the app</a>
                </div>
                <a class="habit-launch-note" href="#purchase"><span>Launch special</span> <strong data-habit-price="offer">{{ $prices['USD']['offer'] }}</strong> <span>instead of <s data-habit-price="regular">{{ $prices['USD']['regular'] }}</s> &middot; One-time payment</span></a>
                <p class="habit-platform-note">Currently available for Windows 10 and 11</p>
            </div>

            <div class="habit-container habit-app-stage" aria-label="Habit Tracker monthly planner preview">
                @if ($pageInfo->hero_image)
                    <img class="habit-uploaded-preview habit-uploaded-hero" src="{{ asset('storage/'.$pageInfo->hero_image) }}" alt="Habit Tracker monthly planner" width="1600" height="1000" fetchpriority="high" decoding="async">
                @else
                <div class="planner-window">
                    <div class="planner-toolbar">
                        <strong><span>HABIT</span>TRACKER</strong>
                        <nav aria-label="Product preview navigation"><span class="is-current">Monthly planner</span><span>History</span><span>Analytics</span></nav>
                        <span>October 2026</span>
                    </div>
                    <div class="planner-body">
                        <div class="planner-habits">
                            <p class="preview-label">Your month, with intention</p>
                            <h2>HABITS:</h2>
                            <p class="preview-script">One ring. One habit. Every day.</p>
                            <ol>
                                <li>Exercise</li><li>Read 20 pages</li><li>Drink more water</li><li>Deep work</li>
                                <li>Sleep before 11</li><li>Meditation</li><li>Spend time outside</li><li>Practice gratitude</li>
                            </ol>
                        </div>
                        <div class="habit-ring" aria-hidden="true">
                            <div class="habit-ring-center"><small>MONTH / YEAR</small><strong>OCTOBER</strong><span>2026</span></div>
                        </div>
                        <div class="planner-notes">
                            <h3>MONTHLY<br>PLANNING</h3>
                            <div class="preview-note-sheet"><strong>OBSERVATIONS</strong><span>A morning walk makes a difference.</span><span>Consistency over perfection.</span><span>Make room for a little reading.</span></div>
                            <div class="preview-goals"><strong>KEY GOALS</strong><div><span>Move every day</span><span>Finish two books</span><span>Protect my mornings</span></div></div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="habit-preview-caption"><span>Your habits. Your goals. One clear view.</span><span>Made for your Windows desktop</span></div>
            </div>
        </section>

        <section class="habit-problem" aria-labelledby="habit-problem-title">
            <div class="habit-container habit-problem-grid">
                <h2 id="habit-problem-title">Make room for the person you want to become.</h2>
                <div>
                    <p>Scattered notes and forgotten resolutions make progress hard to see. Habit Tracker gives every month one clear place for the routines that matter.</p>
                    <p>You do not need a perfect month. You need a clear next step, a place to start again, and a reminder that small efforts count.</p>
                </div>
            </div>
        </section>

        <section class="habit-benefits" aria-labelledby="habit-benefits-title">
            <div class="habit-container">
                <div class="habit-section-heading">
                    <p>One system for steady progress</p>
                    <h2 id="habit-benefits-title">Plan with intention.<br>Act with clarity.</h2>
                </div>
                <div class="habit-benefit-list">
                    <article><span>01</span><h3>Make your priorities visible</h3><p>Choose the habits that deserve your attention and keep them in view throughout the month.</p></article>
                    <article><span>02</span><h3>Build momentum every day</h3><p>A satisfying visual record makes small wins tangible and helps you return after an imperfect day.</p></article>
                    <article><span>03</span><h3>Learn from real patterns</h3><p>See completion, missed days, and longer-term trends so your next plan is grounded in evidence.</p></article>
                </div>
            </div>
        </section>

        <div id="features">
            <section class="habit-feature" aria-labelledby="planner-feature-title">
                <div class="habit-container habit-feature-grid">
                    <div class="habit-feature-copy">
                        <p>Monthly planning</p>
                        <h2 id="planner-feature-title">Your entire month, at a glance.</h2>
                        <p>Build a focused list of habits, set key goals, and capture observations beside a radial calendar that makes every day count.</p>
                        <ul><li>Up to ten focused habits</li><li>Daily completion and missed-day tracking</li><li>Monthly goals and reflection notes</li></ul>
                    </div>
                    @if ($pageInfo->planner_image)
                        <img class="habit-uploaded-preview" src="{{ asset('storage/'.$pageInfo->planner_image) }}" alt="Habit Tracker monthly planning" width="1200" height="800" loading="lazy" decoding="async">
                    @else
                    <div class="habit-feature-visual ring-detail" aria-label="Monthly habit ring illustration">
                        <div class="detail-ring"><span>31 days</span><strong>8 habits</strong></div>
                    </div>
                    @endif
                </div>
            </section>

            <section class="habit-feature habit-feature-light" aria-labelledby="history-feature-title">
                <div class="habit-container habit-feature-grid is-reversed">
                    <div class="habit-feature-copy">
                        <p>Progress history</p>
                        <h2 id="history-feature-title">A record of showing up.</h2>
                        <p>Every completed month becomes part of a clean personal archive. Look back without losing the context behind your numbers.</p>
                        <ul><li>Month-by-month completion</li><li>Completed and missed totals</li><li>Read-only historical snapshots</li></ul>
                    </div>
                    @if ($pageInfo->history_image)
                        <img class="habit-uploaded-preview" src="{{ asset('storage/'.$pageInfo->history_image) }}" alt="Habit Tracker progress history" width="1200" height="800" loading="lazy" decoding="async">
                    @else
                    <div class="habit-feature-visual history-preview" aria-label="Habit Tracker history preview">
                        <div class="history-head"><span>MONTH / YEAR</span><span>COMPLETION</span><span>STATUS</span></div>
                        @foreach ([['10', 'October', '0.0%', 'ACTIVE'], ['09', 'September', '95.7%', 'ARCHIVED'], ['08', 'August', '89.7%', 'ARCHIVED'], ['07', 'July', '89.7%', 'ARCHIVED']] as $month)
                            <div class="history-row"><b>{{ $month[0] }}</b><strong>{{ $month[1] }}<small>2026</small></strong><span>{{ $month[2] }}<i style="--progress: {{ $month[2] }}"></i></span><em>{{ $month[3] }}</em></div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </section>

            <section class="habit-feature" aria-labelledby="analytics-feature-title">
                <div class="habit-container habit-feature-grid">
                    <div class="habit-feature-copy">
                        <p>Progress analytics</p>
                        <h2 id="analytics-feature-title">See what your effort is adding up to.</h2>
                        <p>Move beyond streaks. Compare each habit, understand your coverage, and find the routines that create the strongest momentum.</p>
                        <ul><li>Habit-by-habit completion</li><li>Monthly totals and coverage</li><li>Long-term consistency trends</li></ul>
                    </div>
                    @if ($pageInfo->analytics_image)
                        <img class="habit-uploaded-preview" src="{{ asset('storage/'.$pageInfo->analytics_image) }}" alt="Habit Tracker progress analytics" width="1200" height="800" loading="lazy" decoding="async">
                    @else
                    <div class="habit-feature-visual analytics-preview" aria-label="Habit analytics chart preview">
                        <header><strong>Habit by habit</strong><span>COMPLETION %</span></header>
                        @foreach ([91, 91, 86, 91, 90, 88, 90, 94] as $value)
                            <div class="analytics-bar"><span>{{ ['Exercise', 'Read 20 pages', 'Drink more water', 'Deep work', 'Sleep before 11', 'Meditation', 'Spend time outside', 'Practice gratitude'][$loop->index] }}</span><i style="--value: {{ $value }}%"></i></div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </section>
        </div>

        <section class="habit-routine" aria-labelledby="habit-routine-title">
            <div class="habit-container">
                <h2 id="habit-routine-title">A better routine should feel simple.</h2>
                <p class="habit-routine-lede">A quiet moment at your desk. A small promise to yourself. A little more intention in your day.</p>
                <div class="habit-steps">
                    <article><span>1</span><h3>Choose</h3><p>Set a small number of meaningful habits for the month.</p></article>
                    <article><span>2</span><h3>Show up</h3><p>Mark each day in seconds and keep your priorities close.</p></article>
                    <article><span>3</span><h3>Reflect</h3><p>Use your history and analytics to make the next month better.</p></article>
                </div>
            </div>
        </section>

        <section class="habit-demo" id="demo" aria-labelledby="habit-demo-title">
            <div class="habit-container">
                <div class="habit-demo-heading">
                    <div>
                        <p class="habit-demo-label">A closer look</p>
                        <h2 id="habit-demo-title">See your routine<br>come to life.</h2>
                    </div>
                    <p>Take a moment to explore a more intentional day. Watch the video, then make room for the habits that matter to you.</p>
                </div>
                <figure class="habit-demo-media">
                    <div class="habit-demo-player">
                        <iframe
                            src="{{ $pageInfo->videoEmbedUrl() }}"
                            title="Habit Tracker video preview"
                            width="1280"
                            height="720"
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>
                    </div>
                    <figcaption>
                        <span>A little intention. A little progress. Every day.</span>
                        <a href="{{ 'https://www.youtube.com/watch?v='.\App\Models\HabitTrackerPage::youtubeId($pageInfo->video_url) }}" target="_blank" rel="noopener noreferrer">Watch on YouTube<span class="sr-only"> (opens in a new tab)</span></a>
                    </figcaption>
                </figure>
            </div>
        </section>

        <section class="habit-purchase" id="purchase" aria-labelledby="habit-purchase-title">
            <div class="habit-container habit-purchase-inner">
                <div class="habit-offer-copy">
                    <p>Habit Tracker for Windows &middot; Launch special</p>
                    <h2 id="habit-purchase-title">Better habits.<br>One small investment.</h2>
                    <div class="habit-offer-description">Be among our first 100 customers and unlock Habit Tracker for just <span data-habit-price="offer">{{ $prices['USD']['offer'] }}</span> instead of <span data-habit-price="regular">{{ $prices['USD']['regular'] }}</span>. Pay once, enjoy your app without recurring fees.</div>
                    <ul class="habit-offer-benefits">
                        <li>Plan your month and track daily habits</li>
                        <li>Review your history and progress</li>
                        <li>Keep your routine going offline</li>
                    </ul>
                </div>
                <section class="habit-purchase-action" aria-labelledby="habit-offer-title">
                    <div class="habit-offer-header">
                        <h3 id="habit-offer-title">Your Windows app</h3>
                        <span class="habit-discount-badge" data-habit-price="discount">{{ $prices['USD']['discount'] }}</span>
                    </div>
                    <fieldset class="habit-currency" hidden>
                        <legend>Choose your region</legend>
                        <div class="habit-currency-options">
                            <label><input type="radio" name="habit-currency" value="BDT"><span>Bangladesh <small>BDT</small></span></label>
                            <label><input type="radio" name="habit-currency" value="USD" checked><span>International <small>USD</small></span></label>
                        </div>
                    </fieldset>
                    <noscript><p>Bangladesh: {{ $prices['BDT']['offer'] }} launch price, normally {{ $prices['BDT']['regular'] }} ({{ $prices['BDT']['discount'] }}).</p></noscript>
                    <div class="habit-offer-price" aria-live="polite" aria-atomic="true">
                        <span class="sr-only">Launch price:</span><strong><span class="habit-price-whole" data-habit-price="offer">{{ $prices['USD']['offer'] }}</span><span data-habit-price="decimals">{{ $prices['USD']['decimals'] }}</span></strong>
                        <span class="habit-original-price"><span class="sr-only">Original price:</span><s data-habit-price="regularFull">{{ $prices['USD']['regularFull'] }}</s><small data-habit-price="currency">USD</small></span>
                    </div>
                    <p class="habit-payment-note">One-time payment. No subscription.</p>
                    <p class="habit-offer-limit">Limited to the First 100 Customers</p>
                    <a class="habit-button habit-button-primary" href="{{ route('contact', ['interest' => 'habit-tracker']) }}"><span>Get Habit Tracker for <span data-habit-price="offer">{{ $prices['USD']['offer'] }}</span></span> <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M10 5l5 5-5 5"/></svg></a>
                    <p class="habit-purchase-help">Opens a purchase inquiry. No payment is taken here.</p>
                    <div class="habit-offer-terms">Launch pricing applies to the first 100 successfully paid, eligible purchases. Standard price after the offer: <span data-habit-price="regularFull">{{ $prices['USD']['regularFull'] }}</span>.</div>
                    <small>Windows 10 and 11 compatible</small>
                </section>
            </div>
        </section>

        <section class="habit-faq" aria-labelledby="habit-faq-title">
            <div class="habit-container habit-faq-grid">
                <h2 id="habit-faq-title">Good to know.</h2>
                <div>
                    <details><summary>Who is Habit Tracker for?</summary><p>It is for anyone who wants a deliberate, visual system for building routines without the noise of an overcomplicated productivity suite.</p></details>
                    <details><summary>Which devices does it support?</summary><p>Habit Tracker is designed as a Windows desktop application for Windows 10 and 11.</p></details>
                    <details><summary>What can I track?</summary><p>You can plan daily habits, record completion or missed days, write monthly observations, set key goals, and review progress over time.</p></details>
                    <details><summary>How do I purchase a license?</summary><p>Use the purchase button to get in touch about a Windows license, pricing, and availability.</p></details>
                </div>
            </div>
        </section>
    </article>
</x-frontend::layout>
