<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Shamsur Rahman portfolio specializing in Laravel, PHP, backend systems, APIs, and full-stack web applications.">

        <title>Shamsur Rahman Portfolio</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <a class="skip-link" href="#main">Skip to content</a>

        @include('partials.site-header')

        <main id="main">
            <section class="hero section-pad" id="home" aria-labelledby="hero-title">
                <div class="ambient-grid" aria-hidden="true"></div>
                <div class="container hero-grid">
                    <div class="hero-copy reveal">
                        <p class="eyebrow">Available for selected engineering work</p>
                        <h1 id="hero-title" class="hero-title">
                            <span>Software</span>
                            <span>Engineer</span>
                        </h1>
                        <p class="hero-lede">
                            I design and build Laravel applications, REST APIs, eCommerce systems, and polished full-stack web experiences that are fast, maintainable, and ready for real users.
                        </p>

                        <div class="hero-actions" aria-label="Primary calls to action">
                            <a class="button button-primary" href="#projects">View projects</a>
                            <a class="button button-secondary" href="#contact">Start a conversation</a>
                        </div>

                        <div class="hero-metrics" aria-label="Professional highlights">
                            <div>
                                <strong>35+</strong>
                                <span>production features shipped</span>
                            </div>
                            <div>
                                <strong>8+</strong>
                                <span>core web technologies</span>
                            </div>
                            <div>
                                <strong>100%</strong>
                                <span>practical, maintainable delivery</span>
                            </div>
                        </div>
                    </div>

                    <div class="hero-visual reveal" aria-label="Original profile artwork and engineering summary">
                        <div class="profile-card">
                            <div class="profile-art">
                                <img src="{{ asset('assets/images/My_pic.png') }}" alt="Profile photo of the Software Engineer">
                            </div>
                            <div class="profile-caption">
                                <strong>Shamsur Rahman</strong>
                                <span>Reliable products, clean systems, measurable delivery.</span>
                            </div>
                        </div>

                        <div class="system-panel">
                            <div class="status-line">
                                <span>Current focus</span>
                                <strong>Laravel systems</strong>
                            </div>
                            <div class="meter"><span></span></div>
                            <div class="status-line">
                                <span>Core strengths</span>
                                <strong>Backend, APIs, UI</strong>
                            </div>
                            <div class="stack-orbit" aria-hidden="true">
                                <span>PHP</span>
                                <span>MySQL</span>
                                <span>REST</span>
                                <span>Vite</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-pad" id="about" aria-labelledby="about-title">
                <div class="container split-section">
                    <div class="section-heading reveal">
                        <p class="eyebrow">About</p>
                        <h2 id="about-title">Engineering that balances product speed with long-term clarity.</h2>
                    </div>
                    <div class="about-content reveal">
                        <p>
                            I help teams turn business requirements into durable web systems: clean Laravel backends, thoughtful database design, practical frontend interfaces, and APIs that behave predictably under real usage.
                        </p>
                        <p>
                            My work style is direct and implementation-focused. I care about readable code, measurable performance, secure defaults, and building features that another engineer can confidently extend.
                        </p>
                        <div class="about-grid">
                            <div>
                                <strong>Backend focus</strong>
                                <span>Laravel, PHP, MySQL, queues, APIs, auth flows, and integrations.</span>
                            </div>
                            <div>
                                <strong>Frontend delivery</strong>
                                <span>Responsive Blade interfaces, JavaScript interactions, and polished UI states.</span>
                            </div>
                            <div>
                                <strong>Problem solving</strong>
                                <span>Debugging, performance reviews, refactors, and production maintenance.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-pad muted-band" id="skills" aria-labelledby="skills-title">
                <div class="container">
                    <div class="section-heading center reveal">
                        <p class="eyebrow">Tech stack</p>
                        <h2 id="skills-title">Tools I use to design, build, optimize, and ship web applications.</h2>
                    </div>

                    <div class="skill-grid reveal">
                        <span>Laravel</span>
                        <span>PHP</span>
                        <span>MySQL</span>
                        <span>JavaScript</span>
                        <span>jQuery</span>
                        <span>HTML</span>
                        <span>CSS</span>
                        <span>REST API</span>
                        <span>Git</span>
                        <span>Vite</span>
                        <span>Blade</span>
                        <span>Queues</span>
                        <span>Server basics</span>
                        <span>Deployment</span>
                        <span>Performance</span>
                        <span>Debugging</span>
                    </div>
                </div>
            </section>

            <section class="section-pad" id="services" aria-labelledby="services-title">
                <div class="container">
                    <div class="section-heading reveal">
                        <p class="eyebrow">Services</p>
                        <h2 id="services-title">Focused engineering support for Laravel and full-stack products.</h2>
                    </div>

                    <div class="service-grid">
                        <article class="service-card reveal">
                            <span>01</span>
                            <h3>Laravel web application development</h3>
                            <p>Custom dashboards, business workflows, admin panels, and maintainable feature development using Laravel conventions.</p>
                        </article>
                        <article class="service-card reveal">
                            <span>02</span>
                            <h3>Backend development</h3>
                            <p>Domain logic, authentication, queues, notifications, file handling, and clean service boundaries for growing applications.</p>
                        </article>
                        <article class="service-card reveal">
                            <span>03</span>
                            <h3>API development and integration</h3>
                            <p>RESTful APIs, third-party integrations, webhooks, payment flows, and predictable error handling.</p>
                        </article>
                        <article class="service-card reveal">
                            <span>04</span>
                            <h3>eCommerce development</h3>
                            <p>Product catalogs, carts, checkout flows, order management, inventory logic, and payment integrations.</p>
                        </article>
                        <article class="service-card reveal">
                            <span>05</span>
                            <h3>Database optimization</h3>
                            <p>Query tuning, indexing strategy, schema cleanup, and practical performance improvements for MySQL-backed products.</p>
                        </article>
                        <article class="service-card reveal">
                            <span>06</span>
                            <h3>Bug fixing and maintenance</h3>
                            <p>Production issue triage, refactoring, dependency-aware fixes, and ongoing stability work.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section-pad muted-band" id="projects" aria-labelledby="projects-title">
                <div class="container">
                    <div class="section-heading center reveal">
                        <p class="eyebrow">Selected projects</p>
                        <h2 id="projects-title">Project concepts that reflect the systems I build for real clients and teams.</h2>
                    </div>

                    <div class="project-grid">
                        @foreach ($featuredProjects as $project)
                            @include('partials.project-card', ['project' => $project])
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
                        <h2 id="experience-title">Practical delivery across product builds, integrations, and optimization work.</h2>
                    </div>

                    <div class="timeline reveal">
                        <article>
                            <span>2024 - Present</span>
                            <h3>Shamsur Rahman</h3>
                            <p>Building Laravel applications, REST APIs, admin dashboards, and integration workflows for operational teams.</p>
                        </article>
                        <article>
                            <span>2022 - 2024</span>
                            <h3>Laravel Developer</h3>
                            <p>Delivered eCommerce features, database-backed business tools, bug fixes, and performance improvements.</p>
                        </article>
                        <article>
                            <span>2020 - 2022</span>
                            <h3>Full-stack Web Developer</h3>
                            <p>Created responsive interfaces, PHP modules, jQuery interactions, and deployment-ready websites for small businesses.</p>
                        </article>
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
                        <h2 id="contact-title">Have a Laravel product, API, or web workflow that needs careful execution?</h2>
                        <p>Send a short brief and I will respond with practical next steps, technical questions, and a clear path to delivery.</p>

                        <div class="contact-list">
                            <a href="mailto:hello@example.com">hello@example.com</a>
                            <a href="tel:+10000000000">+1 000 000 0000</a>
                            <span>Available remotely</span>
                        </div>

                        <div class="social-row" aria-label="Social profile links">
                            <a href="#contact">GitHub</a>
                            <a href="#contact">LinkedIn</a>
                            <a href="#contact">X</a>
                        </div>
                    </div>

                    <form class="contact-form reveal" action="mailto:hello@example.com" method="post" enctype="text/plain" data-contact-form>
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
                        <p class="form-note" data-form-note>Form opens your email client. Replace the placeholder email before launch.</p>
                    </form>
                </div>
            </section>
        </main>

        @include('partials.site-footer')
    </body>
</html>
