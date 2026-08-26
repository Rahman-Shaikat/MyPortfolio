<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::lower(Str::random(6)),
            'url' => fake()->url(),
            'description' => fake()->paragraph(),
            'technologies' => fake()->randomElements(
                ['Laravel', 'PHP', 'MySQL', 'Redis', 'JavaScript', 'Blade'],
                3
            ),
            'is_personal' => false,
            'sort_order' => fake()->numberBetween(1, 100),
            'status' => true,
        ];
    }

    public function personal(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_personal' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => false,
        ]);
    }
}
