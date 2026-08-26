<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::query()->updateOrCreate(['id' => 1], [
            'name' => 'Shamsur Rahman',
            'brand_initials' => 'SR',
            'professional_title' => 'Software Engineer',
            'header_subtitle' => 'Laravel and full-stack web',
            'availability_text' => 'Available for selected engineering work',
            'seo_description' => 'Shamsur Rahman portfolio specializing in Laravel, PHP, backend systems, APIs, and full-stack web applications.',
            'hero_title_line_one' => 'Software',
            'hero_title_line_two' => 'Engineer',
            'hero_description' => 'I design and build Laravel applications, REST APIs, eCommerce systems, and polished full-stack web experiences that are fast, maintainable, and ready for real users.',
            'profile_caption' => 'Reliable products, clean systems, measurable delivery.',
            'current_focus' => 'Laravel systems',
            'core_strengths' => 'Backend, APIs, UI',
            'orbit_skills' => ['PHP', 'MySQL', 'REST', 'Vite'],
            'hero_metrics' => [
                ['value' => '35+', 'label' => 'production features shipped'],
                ['value' => '8+', 'label' => 'core web technologies'],
                ['value' => '100%', 'label' => 'practical, maintainable delivery'],
            ],
            'about_title' => 'Engineering that balances product speed with long-term clarity.',
            'about_paragraph_one' => 'I help teams turn business requirements into durable web systems: clean Laravel backends, thoughtful database design, practical frontend interfaces, and APIs that behave predictably under real usage.',
            'about_paragraph_two' => 'My work style is direct and implementation-focused. I care about readable code, measurable performance, secure defaults, and building features that another engineer can confidently extend.',
            'about_highlights' => [
                ['title' => 'Backend focus', 'description' => 'Laravel, PHP, MySQL, queues, APIs, auth flows, and integrations.'],
                ['title' => 'Frontend delivery', 'description' => 'Responsive Blade interfaces, JavaScript interactions, and polished UI states.'],
                ['title' => 'Problem solving', 'description' => 'Debugging, performance reviews, refactors, and production maintenance.'],
            ],
            'skills_title' => 'Tools I use to design, build, optimize, and ship web applications.',
            'skills' => ['Laravel', 'PHP', 'MySQL', 'JavaScript', 'jQuery', 'HTML', 'CSS', 'REST API', 'Git', 'Vite', 'Blade', 'Queues', 'Server basics', 'Deployment', 'Performance', 'Debugging'],
            'services_title' => 'Focused engineering support for Laravel and full-stack products.',
            'services' => [
                ['title' => 'Laravel web application development', 'description' => 'Custom dashboards, business workflows, admin panels, and maintainable feature development using Laravel conventions.'],
                ['title' => 'Backend development', 'description' => 'Domain logic, authentication, queues, notifications, file handling, and clean service boundaries for growing applications.'],
                ['title' => 'API development and integration', 'description' => 'RESTful APIs, third-party integrations, webhooks, payment flows, and predictable error handling.'],
                ['title' => 'eCommerce development', 'description' => 'Product catalogs, carts, checkout flows, order management, inventory logic, and payment integrations.'],
                ['title' => 'Database optimization', 'description' => 'Query tuning, indexing strategy, schema cleanup, and practical performance improvements for MySQL-backed products.'],
                ['title' => 'Bug fixing and maintenance', 'description' => 'Production issue triage, refactoring, dependency-aware fixes, and ongoing stability work.'],
            ],
            'projects_title' => 'Selected platforms I have built and supported for clients, teams, and personal products.',
            'experience_title' => 'Practical delivery across product builds, integrations, and optimization work.',
            'experiences' => [
                ['period' => '2024 - Present', 'title' => 'Software Engineer', 'description' => 'Building Laravel applications, REST APIs, admin dashboards, and integration workflows for operational teams.'],
                ['period' => '2022 - 2024', 'title' => 'Laravel Developer', 'description' => 'Delivered eCommerce features, database-backed business tools, bug fixes, and performance improvements.'],
                ['period' => '2020 - 2022', 'title' => 'Full-stack Web Developer', 'description' => 'Created responsive interfaces, PHP modules, jQuery interactions, and deployment-ready websites for small businesses.'],
            ],
            'contact_title' => 'Have a Laravel product, API, or web workflow that needs careful execution?',
            'contact_description' => 'Send a short brief and I will respond with practical next steps, technical questions, and a clear path to delivery.',
            'email' => 'hello@example.com',
            'phone' => '+1 000 000 0000',
            'location' => 'Available remotely',
        ]);
    }
}
