<?php

namespace Database\Factories;

use App\Models\HabitTrackerPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HabitTrackerPage>
 */
class HabitTrackerPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => 1,
            'video_url' => 'https://youtu.be/_N37glNeUms',
            'usd_regular_price' => '15.00',
            'usd_offer_price' => '5.00',
            'bdt_regular_price' => '1800.00',
            'bdt_offer_price' => '500.00',
        ];
    }
}
