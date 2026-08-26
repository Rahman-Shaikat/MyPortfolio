<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::query()->updateOrCreate(['id' => 1], [
            'name' => 'Md. Shamsur Rahman',
            'brand_initials' => 'MSR',
            'professional_title' => 'Software Engineer',
            'header_subtitle' => 'Laravel / PHP Backend Development',
            'availability_text' => 'Available for selected engineering work',
            'seo_description' => 'Software Engineer in Dhaka, Bangladesh specializing in Laravel and PHP backend development, REST APIs, databases, CMS and e-commerce systems, with AI and LLM research experience.',
            'hero_title_line_one' => 'Md. Shamsur Rahman',
            'hero_title_line_two' => 'Software Engineer',
            'hero_description' => 'I am a Software Engineer based in Dhaka, Bangladesh with 3+ years of professional experience building Laravel and PHP backends, REST APIs, CMS and e-commerce systems across 20+ production and client projects. I also work on AI and LLM evaluation research for Bangla and other low-resource settings.',
            'profile_caption' => 'Reliable products, clean systems, measurable delivery.',
            'current_focus' => 'Laravel systems',
            'core_strengths' => 'Backend, APIs, databases',
            'orbit_skills' => ['PHP', 'MySQL', 'Redis', 'Docker'],
            'hero_metrics' => [
                ['value' => '3+', 'label' => 'years of professional experience'],
                ['value' => '20+', 'label' => 'production and client projects'],
                ['value' => '1', 'label' => 'accepted AI research publication'],
            ],
            'about_title' => 'Laravel backend engineering grounded in production delivery and careful problem solving.',
            'about_paragraph_one' => 'I am Md. Shamsur Rahman, a Software Engineer based in Dhaka, Bangladesh. I specialize in Laravel and PHP backend development, including RESTful APIs, Eloquent ORM, relational database design, authentication, integrations, CMS platforms, and e-commerce systems.',
            'about_paragraph_two' => 'Across 3+ years and 20+ production and client projects, my work has also included MySQL query optimization, Redis caching, Docker, Linux deployment, Git-based delivery, production debugging, and application troubleshooting. My research interests include AI, NLP, responsible AI, and evaluation of Bangla large language models.',
            'about_highlights' => [
                ['title' => 'Laravel backend engineering', 'description' => 'Laravel, PHP, Eloquent, Query Builder, authentication, authorization, queues, and maintainable application architecture.'],
                ['title' => 'Data and integrations', 'description' => 'REST APIs, MySQL schema design, query optimization, Redis caching, third-party services, and payment integrations.'],
                ['title' => 'Production and research', 'description' => 'Docker, Linux deployment, debugging, troubleshooting, AI, LLM evaluation, responsible AI, and Bangla NLP research.'],
            ],
            'skills_title' => 'Tools I use to design, build, optimize, and ship web applications.',
            'skills' => ['Laravel', 'PHP', 'MySQL', 'Eloquent ORM', 'Query Builder', 'REST API', 'Redis', 'Docker', 'Blade', 'JavaScript', 'jQuery', 'AJAX', 'HTML', 'CSS', 'Git', 'GitHub', 'Composer', 'Linux', 'Deployment', 'Debugging'],
            'services_title' => 'Expertise across backend systems, integrations, data, production support, and AI research.',
            'services' => [
                ['title' => 'Laravel Backend Engineering', 'description' => 'Production Laravel and PHP development using MVC, Eloquent ORM, Query Builder, authentication, authorization, reusable Blade components, and maintainable backend architecture.'],
                ['title' => 'REST API & Integrations', 'description' => 'RESTful API development, third-party services, webhooks, payment integrations, external APIs, and predictable error handling.'],
                ['title' => 'Database & Performance', 'description' => 'MySQL relational schema design, migrations, relationships, query optimization, database partitioning, and Redis caching for data-intensive applications.'],
                ['title' => 'E-commerce & CMS', 'description' => 'Professional development of catalogues, shopping workflows, content-management systems, publication platforms, and administrative tools.'],
                ['title' => 'Deployment & Production Support', 'description' => 'Docker, Linux deployment, Git-based delivery, logs, production debugging, server troubleshooting, and ongoing application maintenance.'],
                ['title' => 'AI & LLM Research', 'description' => 'Research interests in NLP, LLM evaluation, responsible AI, benchmark development, social bias, cultural commonsense, and Bangla language models.'],
            ],
            'projects_title' => 'Selected platforms I have built and supported for clients, teams, and personal products.',
            'experience_title' => 'Practical delivery across product builds, integrations, and optimization work.',
            'experiences' => [
                ['period' => '2024 - Present', 'title' => 'Software Engineer', 'description' => 'Building Laravel applications, REST APIs, admin dashboards, and integration workflows for operational teams.'],
                ['period' => '2022 - 2024', 'title' => 'Laravel Developer', 'description' => 'Delivered eCommerce features, database-backed business tools, bug fixes, and performance improvements.'],
                ['period' => '2020 - 2022', 'title' => 'Full-stack Web Developer', 'description' => 'Created responsive interfaces, PHP modules, jQuery interactions, and deployment-ready websites for small businesses.'],
            ],
            'contact_title' => 'Have a Laravel product, API, or web workflow that needs careful execution?',
            'contact_description' => 'Send a short brief about your Laravel application, backend system, REST API, CMS, e-commerce workflow, or production issue, and I will respond with practical technical next steps.',
            'location' => 'Dhaka, Bangladesh',
            'github_url' => 'https://github.com/Rahman-Shaikat',
            'linkedin_url' => 'https://www.linkedin.com/in/rahman-shaikat-7254651b7',
        ]);
    }
}
