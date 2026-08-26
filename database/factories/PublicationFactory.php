<?php

namespace Database\Factories;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(6),
            'publisher' => fake()->company(),
            'published_at' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'description' => fake()->paragraph(),
            'url' => fake()->url(),
            'sort_order' => fake()->numberBetween(1, 100),
            'status' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => false,
        ]);
    }
}
