<x-frontend::layout :profile="$profile" :seo="$seo">
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
                            <a class="button button-primary" href="{{ route('projects.index') }}">View Laravel and backend projects</a>
                            <a class="button button-secondary" href="{{ route('contact') }}">Start a conversation</a>
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
                                <img src="{{ $profile->profile_image ? asset('storage/'.$profile->profile_image) : asset('assets/images/My_Pic.png') }}" alt="Profile photo of {{ $profile->name }}" width="1024" height="1005" fetchpriority="high" decoding="async">
                            </div>
                            <div class="profile-caption">
                                <strong>{{ $profile->name }}</strong>
                                <a class="profile-resume-button" href="{{ route('resume.show') }}">
                                    View resume
                                    <span class="profile-resume-button-icon" aria-hidden="true">&#8599;</span>
                                </a>
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
                        <a class="text-link" href="{{ route('about') }}">More about my engineering background</a>
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
                        <a class="button button-secondary" href="{{ route('projects.index') }}">View all projects</a>
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

            <section class="section-pad" id="research" aria-labelledby="research-title">
                <div class="container">
                    <div class="section-heading reveal">
                        <p class="eyebrow">Research</p>
                        <h2 id="research-title">Responsible AI and culturally grounded evaluation for Bangla language models.</h2>
                    </div>

                    <div class="thought-grid">
                        @forelse ($featuredPublications as $publication)
                            @include('frontend.partials.publication-card', ['publication' => $publication])
                        @empty
                            <p class="empty-state">Research records will appear here when published.</p>
                        @endforelse
                    </div>

                    <div class="section-actions reveal">
                        <a class="button button-secondary" href="{{ route('research.index') }}">Explore research</a>
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
</x-frontend::layout>
