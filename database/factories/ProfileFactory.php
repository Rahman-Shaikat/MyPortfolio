<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'brand_initials' => fake()->lexify('??'),
            'professional_title' => 'Software Engineer',
            'header_subtitle' => 'Laravel and full-stack web',
            'availability_text' => 'Available for selected engineering work',
            'seo_description' => fake()->sentence(),
            'hero_title_line_one' => 'Software',
            'hero_title_line_two' => 'Engineer',
            'hero_description' => fake()->paragraph(),
            'orbit_skills' => ['PHP', 'MySQL', 'REST', 'Vite'],
            'hero_metrics' => [
                ['value' => '5+', 'label' => 'years of experience'],
            ],
            'about_highlights' => [],
            'skills' => ['Laravel', 'PHP', 'MySQL'],
            'services' => [],
            'experiences' => [],
        ];
    }
}
