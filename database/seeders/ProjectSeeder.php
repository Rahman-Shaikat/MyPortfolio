<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'name' => 'bdnews24.com',
                'url' => 'https://bdnews24.com',
                'description' => 'Contributed to Bangla and English CMS/frontend development, including content workflows, caching, deployment, and ongoing maintenance.',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Redis'],
                'is_personal' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sanitation Knowledge Repository',
                'url' => 'https://www.sanirepo.com',
                'description' => 'Built a research and publication-sharing platform for ITN-BUET with publication, categorization, administration, and content-delivery workflows.',
                'technologies' => ['Laravel', 'PHP', 'MySQL'],
                'is_personal' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Jhingephul Publication',
                'url' => 'https://jhingephul.com',
                'description' => 'Developed the online bookstore backend, catalogue, and content-management workflows.',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'E-commerce'],
                'is_personal' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Taan',
                'url' => 'https://taanbd.com',
                'description' => 'Independently developed the complete e-commerce platform from scratch, covering frontend, backend, database design, and secure payment integration.',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'E-commerce', 'Payment Integration'],
                'is_personal' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Khalid Sangeet',
                'url' => 'https://khalidsangeet.com',
                'description' => 'Developed the backend and administrative functionality for the platform.',
                'technologies' => ['Laravel', 'PHP', 'MySQL'],
                'is_personal' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'Step Footwear',
                'url' => 'https://stepfootwear.com',
                'description' => 'Developed backend and product-management workflows supporting catalogue, content, and customer-facing functionality.',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'E-commerce'],
                'is_personal' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'Resume Engineer',
                'url' => 'https://resumengineer.pixiestorebd.com',
                'description' => 'Built a Laravel resume builder with dynamic resume sections, template selection, and user-managed content.',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Blade'],
                'is_personal' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Kinbo',
                'url' => 'https://shop.pixiestorebd.com',
                'description' => 'Built a Laravel e-commerce application implementing core catalogue and shopping workflows.',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'E-commerce'],
                'is_personal' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(
                ['slug' => Str::slug($project['name'])],
                [...$project, 'status' => true]
            );
        }
    }
}
