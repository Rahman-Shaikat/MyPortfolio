<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reference' => 'HT-'.Str::ulid(),
            'submission_hash' => hash('sha256', Str::uuid()->toString()),
            'payload_hash' => hash('sha256', 'factory'),
            'name' => fake()->name(), 'phone' => '01712345678', 'email' => fake()->safeEmail(),
            'status' => 'pending',
        ];
    }
}
