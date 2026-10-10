<x-frontend::layout :profile="$profile" :seo="$seo" :page-styles="['resources/css/habit-tracker.css']">
    <article class="habit-page">
        <section class="habit-hero" aria-labelledby="habit-hero-title">
            <div class="habit-container habit-hero-copy">
                <p class="habit-product-name">Habit Tracker</p>
                <h1 id="habit-hero-title"><span>Build the routines</span><span>that build your life.</span></h1>
                <p class="habit-hero-lede">A calm, focused Windows desktop app for turning intentions into visible progress. Plan your month, mark each day, and keep showing up.</p>
                <div class="habit-actions">
                    <a class="habit-button habit-button-primary" href="#purchase">
                        Purchase for Windows
                        <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M10 5l5 5-5 5"/></svg>
                    </a>
                    <a class="habit-button habit-button-secondary" href="#features">Explore the app</a>
                </div>
                <p class="habit-platform-note">Designed for Windows 10 and 11</p>
            </div>

            <div class="habit-container habit-app-stage" aria-label="Habit Tracker monthly planner preview">
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
                            <div class="preview-note-sheet"><strong>OBSERVATIONS</strong><span></span><span></span><span></span></div>
                            <div class="preview-goals"><strong>KEY GOALS</strong><div><span>Move every day</span><span>Finish two books</span><span>Protect my mornings</span></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="habit-problem" aria-labelledby="habit-problem-title">
            <div class="habit-container habit-problem-grid">
                <h2 id="habit-problem-title">Busy is not the same as moving forward.</h2>
                <div>
                    <p>Scattered notes and forgotten resolutions make progress hard to see. Habit Tracker gives every month one clear place for the routines that matter.</p>
                    <p>No feeds. No noise. Just a simple daily practice that turns consistency into something you can see, understand, and improve.</p>
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
                    <div class="habit-feature-visual ring-detail" aria-label="Monthly habit ring illustration">
                        <div class="detail-ring"><span>31 days</span><strong>8 habits</strong></div>
                    </div>
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
                    <div class="habit-feature-visual history-preview" aria-label="Habit Tracker history preview">
                        <div class="history-head"><span>MONTH / YEAR</span><span>COMPLETION</span><span>STATUS</span></div>
                        @foreach ([['10', 'October', '0.0%', 'ACTIVE'], ['09', 'September', '95.7%', 'ARCHIVED'], ['08', 'August', '89.7%', 'ARCHIVED'], ['07', 'July', '89.7%', 'ARCHIVED']] as $month)
                            <div class="history-row"><b>{{ $month[0] }}</b><strong>{{ $month[1] }}<small>2026</small></strong><span>{{ $month[2] }}<i style="--progress: {{ $month[2] }}"></i></span><em>{{ $month[3] }}</em></div>
                        @endforeach
                    </div>
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
                    <div class="habit-feature-visual analytics-preview" aria-label="Habit analytics chart preview">
                        <header><strong>Habit by habit</strong><span>COMPLETION %</span></header>
                        @foreach ([91, 91, 86, 91, 90, 88, 90, 94] as $value)
                            <div class="analytics-bar"><span>{{ ['Exercise', 'Read 20 pages', 'Drink more water', 'Deep work', 'Sleep before 11', 'Meditation', 'Spend time outside', 'Practice gratitude'][$loop->index] }}</span><i style="--value: {{ $value }}%"></i></div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>

        <section class="habit-routine" aria-labelledby="habit-routine-title">
            <div class="habit-container">
                <h2 id="habit-routine-title">A better routine should feel simple.</h2>
                <div class="habit-steps">
                    <article><span>1</span><h3>Choose</h3><p>Set a small number of meaningful habits for the month.</p></article>
                    <article><span>2</span><h3>Show up</h3><p>Mark each day in seconds and keep your priorities close.</p></article>
                    <article><span>3</span><h3>Reflect</h3><p>Use your history and analytics to make the next month better.</p></article>
                </div>
            </div>
        </section>

        <section class="habit-purchase" id="purchase" aria-labelledby="habit-purchase-title">
            <div class="habit-container habit-purchase-inner">
                <div>
                    <p>Habit Tracker for Windows</p>
                    <h2 id="habit-purchase-title">Small actions.<br>Lasting change.</h2>
                </div>
                <div class="habit-purchase-action">
                    <p>A focused desktop companion for planning deliberately and building consistency one day at a time.</p>
                    <a class="habit-button habit-button-primary" href="{{ route('contact') }}?interest=habit-tracker">Purchase for Windows <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10h11M10 5l5 5-5 5"/></svg></a>
                    <small>Windows 10 and 11 compatible</small>
                </div>
            </div>
        </section>

        <section class="habit-faq" aria-labelledby="habit-faq-title">
            <div class="habit-container habit-faq-grid">
                <h2 id="habit-faq-title">Good to know.</h2>
                <div>
                    <details><summary>Who is Habit Tracker for?</summary><p>It is for anyone who wants a deliberate, visual system for building routines without the noise of an overcomplicated productivity suite.</p></details>
                    <details><summary>Which devices does it support?</summary><p>Habit Tracker is designed as a Windows desktop application for Windows 10 and 11.</p></details>
                    <details><summary>What can I track?</summary><p>You can plan daily habits, record completion or missed days, write monthly observations, set key goals, and review progress over time.</p></details>
                    <details><summary>How do I purchase a license?</summary><p>Use the purchase button to send your request. Checkout and license delivery will be connected in the next release stage.</p></details>
                </div>
            </div>
        </section>
    </article>
</x-frontend::layout>
