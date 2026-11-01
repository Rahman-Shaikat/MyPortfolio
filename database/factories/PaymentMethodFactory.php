<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    public function definition(): array
    {
        return ['code' => 'bkash_bdt', 'name' => 'bKash', 'type' => 'bkash', 'currency' => 'BDT', 'instructions' => 'Pay to the test merchant account using Payment.', 'enabled' => true];
    }
}
