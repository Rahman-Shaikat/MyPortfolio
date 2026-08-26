<?php

namespace Database\Factories;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = fake()->unique()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(6)),
            'authors' => [fake()->name(), 'Md. Shamsur Rahman'],
            'publisher' => fake()->company(),
            'published_at' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'description' => fake()->paragraph(),
            'url' => fake()->url(),
            'reference_url' => fake()->url(),
            'research_topics' => ['Software Engineering', 'Artificial Intelligence'],
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
