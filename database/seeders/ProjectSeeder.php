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
                'role' => 'Software Engineer',
                'contribution' => 'Contributed to Bangla and English CMS and frontend workflows, caching, deployment, and ongoing production maintenance.',
                'responsibilities' => ['CMS development', 'Frontend workflows', 'Caching', 'Deployment', 'Production maintenance'],
                'contribution_type' => 'contributor',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Redis'],
                'is_personal' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sanitation Knowledge Repository',
                'url' => 'https://www.sanirepo.com',
                'description' => 'Built a research and publication-sharing platform for ITN-BUET with publication, categorization, administration, and content-delivery workflows.',
                'role' => 'Laravel Developer',
                'contribution' => 'Built publication, categorization, administration, and content-delivery workflows for the research repository.',
                'responsibilities' => ['Backend development', 'Publication workflows', 'Administration', 'Database design'],
                'contribution_type' => 'contributor',
                'technologies' => ['Laravel', 'PHP', 'MySQL'],
                'is_personal' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Jhingephul Publication',
                'url' => 'https://jhingephul.com',
                'description' => 'Developed the online bookstore backend, catalogue, and content-management workflows.',
                'role' => 'Backend Developer',
                'contribution' => 'Developed the online bookstore backend, catalogue, and content-management workflows.',
                'responsibilities' => ['Backend development', 'Catalogue workflows', 'Content management'],
                'contribution_type' => 'contributor',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'E-commerce'],
                'is_personal' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Taan',
                'url' => 'https://taanbd.com',
                'description' => 'Independently developed the complete e-commerce platform from scratch, covering frontend, backend, database design, and secure payment integration.',
                'role' => 'Full-stack Laravel Developer',
                'contribution' => 'Independently developed the complete e-commerce platform from scratch, including frontend, backend, database design, and secure payment integration.',
                'responsibilities' => ['Frontend development', 'Backend development', 'Database design', 'Payment integration'],
                'contribution_type' => 'creator',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'E-commerce', 'Payment Integration'],
                'is_personal' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Khalid Sangeet',
                'url' => 'https://khalidsangeet.com',
                'description' => 'Developed the backend and administrative functionality for the platform.',
                'role' => 'Backend Developer',
                'contribution' => 'Developed the backend and administrative functionality for the platform.',
                'responsibilities' => ['Backend development', 'Administrative workflows'],
                'contribution_type' => 'contributor',
                'technologies' => ['Laravel', 'PHP', 'MySQL'],
                'is_personal' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'Step Footwear',
                'url' => 'https://stepfootwear.com',
                'description' => 'Developed backend and product-management workflows supporting catalogue, content, and customer-facing functionality.',
                'role' => 'Backend Developer',
                'contribution' => 'Developed backend and product-management workflows supporting catalogue, content, and customer-facing functionality.',
                'responsibilities' => ['Backend development', 'Product management', 'Catalogue workflows'],
                'contribution_type' => 'contributor',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'E-commerce'],
                'is_personal' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'Resume Engineer',
                'url' => 'https://resumengineer.pixiestorebd.com',
                'description' => 'Built a Laravel resume builder with dynamic resume sections, template selection, and user-managed content.',
                'role' => 'Full-stack Laravel Developer',
                'contribution' => 'Built the Laravel application with dynamic resume sections, template selection, and user-managed content.',
                'responsibilities' => ['Application architecture', 'Backend development', 'Blade interfaces', 'Database design'],
                'contribution_type' => 'creator',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Blade'],
                'is_personal' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Kinbo',
                'url' => 'https://shop.pixiestorebd.com',
                'description' => 'Built a Laravel e-commerce application implementing core catalogue and shopping workflows.',
                'role' => 'Laravel Developer',
                'contribution' => 'Built the Laravel e-commerce application and its core catalogue and shopping workflows.',
                'responsibilities' => ['Backend development', 'Catalogue workflows', 'Shopping workflows', 'Database design'],
                'contribution_type' => 'creator',
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
