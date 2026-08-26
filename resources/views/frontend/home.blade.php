<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ $profile->seo_description ?: $profile->name.' portfolio' }}">

        <title>{{ $profile->name }} Portfolio</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <a class="skip-link" href="#main">Skip to content</a>

        @include('frontend.partials.site-header')

        <main id="main">
            <section class="hero section-pad" id="home" aria-labelledby="hero-title">
                <div class="ambient-grid" aria-hidden="true"></div>
                <div class="container hero-grid">
                    <div class="hero-copy reveal">
                        <p class="eyebrow">{{ $profile->availability_text }}</p>
                        <h1 id="hero-title" class="hero-title">
                            <span>{{ $profile->hero_title_line_one }}</span>
                            <span>{{ $profile->hero_title_line_two }}</span>
                        </h1>
                        <p class="hero-lede">
                            {{ $profile->hero_description }}
                        </p>

                        <div class="hero-actions" aria-label="Primary calls to action">
                            <a class="button button-primary" href="#projects">View projects</a>
                            <a class="button button-secondary" href="#contact">Start a conversation</a>
                            @if ($profile->resume)
                                <a class="button button-secondary" href="{{ asset('storage/'.$profile->resume) }}" target="_blank" rel="noopener noreferrer">View resume</a>
                            @endif
                        </div>

                        <div class="hero-metrics" aria-label="Professional highlights">
                            @foreach ($profile->hero_metrics ?? [] as $metric)
                                <div>
                                    <strong>{{ $metric['value'] }}</strong>
                                    <span>{{ $metric['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="hero-visual reveal" aria-label="Original profile artwork and engineering summary">
                        <div class="profile-card">
                            <div class="profile-art">
                                <img src="{{ $profile->profile_image ? asset('storage/'.$profile->profile_image) : asset('assets/images/My_pic.png') }}" alt="Profile photo of {{ $profile->name }}">
                            </div>
                            <div class="profile-caption">
                                <strong>{{ $profile->name }}</strong>
                                <span>{{ $profile->profile_caption }}</span>
                            </div>
                        </div>

                        <div class="system-panel">
                            <div class="status-line">
                                <span>Current focus</span>
                                <strong>{{ $profile->current_focus }}</strong>
                            </div>
                            <div class="meter"><span></span></div>
                            <div class="status-line">
                                <span>Core strengths</span>
                                <strong>{{ $profile->core_strengths }}</strong>
                            </div>
                            <div class="stack-orbit" aria-hidden="true">
                                @foreach ($profile->orbit_skills ?? [] as $skill)
                                    <span>{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-pad" id="about" aria-labelledby="about-title">
                <div class="container split-section">
                    <div class="section-heading reveal">
                        <p class="eyebrow">About</p>
                        <h2 id="about-title">{{ $profile->about_title }}</h2>
                    </div>
                    <div class="about-content reveal">
                        <p>{{ $profile->about_paragraph_one }}</p>
                        <p>{{ $profile->about_paragraph_two }}</p>
                        <div class="about-grid">
                            @foreach ($profile->about_highlights ?? [] as $highlight)
                                <div>
                                    <strong>{{ $highlight['title'] }}</strong>
                                    <span>{{ $highlight['description'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-pad muted-band" id="skills" aria-labelledby="skills-title">
                <div class="container">
                    <div class="section-heading center reveal">
                        <p class="eyebrow">Tech stack</p>
                        <h2 id="skills-title">{{ $profile->skills_title }}</h2>
                    </div>

                    <div class="skill-grid reveal">
                        @foreach ($profile->skills ?? [] as $skill)
                            <span>{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="section-pad" id="services" aria-labelledby="services-title">
                <div class="container">
                    <div class="section-heading reveal">
                        <p class="eyebrow">Services</p>
                        <h2 id="services-title">{{ $profile->services_title }}</h2>
                    </div>

                    <div class="service-grid">
                        @foreach ($profile->services ?? [] as $service)
                            <article class="service-card reveal">
                                <span>{{ str_pad((string) ($loop->index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                <h3>{{ $service['title'] }}</h3>
                                <p>{{ $service['description'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="section-pad muted-band" id="projects" aria-labelledby="projects-title">
                <div class="container">
                    <div class="section-heading center reveal">
                        <p class="eyebrow">Selected projects</p>
                        <h2 id="projects-title">{{ $profile->projects_title }}</h2>
                    </div>

                    <div class="project-grid">
                        @foreach ($featuredProjects as $project)
                            @include('frontend.partials.project-card', ['project' => $project])
                        @endforeach
                    </div>

                    <div class="section-actions reveal">
                        <a class="button button-secondary" href="{{ route('projects.index') }}">Show More</a>
                    </div>
                </div>
            </section>

            <section class="section-pad" id="experience" aria-labelledby="experience-title">
                <div class="container split-section">
                    <div class="section-heading reveal">
                        <p class="eyebrow">Experience</p>
                        <h2 id="experience-title">{{ $profile->experience_title }}</h2>
                    </div>

                    <div class="timeline reveal">
                        @foreach ($profile->experiences ?? [] as $experience)
                            <article>
                                <span>{{ $experience['period'] }}</span>
                                <h3>{{ $experience['title'] }}</h3>
                                <p>{{ $experience['description'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="section-pad" id="thoughts" aria-labelledby="thoughts-title">
                <div class="container">
                    <div class="section-heading reveal">
                        <p class="eyebrow">Engineering thoughts</p>
                        <h2 id="thoughts-title">Notes on building practical software that survives real production usage.</h2>
                    </div>

                    <div class="thought-grid">
                        <article class="thought-card reveal">
                            <span>6 min read</span>
                            <h3>How I approach Laravel performance before adding infrastructure</h3>
                            <p>Start with query shape, indexes, payload size, and cache boundaries before reaching for bigger servers.</p>
                        </article>
                        <article class="thought-card reveal">
                            <span>5 min read</span>
                            <h3>What makes an API integration maintainable after launch</h3>
                            <p>Clear contracts, retry behavior, useful logs, and isolated provider code make future changes much cheaper.</p>
                        </article>
                        <article class="thought-card reveal">
                            <span>4 min read</span>
                            <h3>Designing admin screens for fast operational decisions</h3>
                            <p>Dense layouts, clean hierarchy, and predictable actions matter more than decorative dashboard surfaces.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section-pad contact-band" id="contact" aria-labelledby="contact-title">
                <div class="container contact-grid">
                    <div class="contact-copy reveal">
                        <p class="eyebrow">Contact</p>
                        <h2 id="contact-title">{{ $profile->contact_title }}</h2>
                        <p>{{ $profile->contact_description }}</p>

                        <div class="contact-list">
                            @if ($profile->email)<a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>@endif
                            @if ($profile->phone)<a href="tel:{{ preg_replace('/[^+0-9]/', '', $profile->phone) }}">{{ $profile->phone }}</a>@endif
                            @if ($profile->location)<span>{{ $profile->location }}</span>@endif
                        </div>

                        <div class="social-row" aria-label="Social profile links">
                            @if ($profile->github_url)<a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer">GitHub</a>@endif
                            @if ($profile->linkedin_url)<a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener noreferrer">LinkedIn</a>@endif
                            @if ($profile->x_url)<a href="{{ $profile->x_url }}" target="_blank" rel="noopener noreferrer">X</a>@endif
                        </div>
                    </div>

                    <form class="contact-form reveal" action="{{ $profile->email ? 'mailto:'.$profile->email : '#contact' }}" method="post" enctype="text/plain" data-contact-form>
                        <label>
                            <span>Name</span>
                            <input type="text" name="name" placeholder="Your name" autocomplete="name" required>
                        </label>
                        <label>
                            <span>Email</span>
                            <input type="email" name="email" placeholder="you@example.com" autocomplete="email" required>
                        </label>
                        <label>
                            <span>Project type</span>
                            <select name="project_type" required>
                                <option value="">Select one</option>
                                <option>Laravel application</option>
                                <option>API or integration</option>
                                <option>eCommerce</option>
                                <option>Maintenance or bug fixing</option>
                            </select>
                        </label>
                        <label>
                            <span>Message</span>
                            <textarea name="message" rows="5" placeholder="Tell me what you want to build or improve." required></textarea>
                        </label>
                        <button class="button button-primary" type="submit">Send inquiry</button>
                        <p class="form-note" data-form-note>Form opens your email client.</p>
                    </form>
                </div>
            </section>
        </main>

        @include('frontend.partials.site-footer')
    </body>
</html>
