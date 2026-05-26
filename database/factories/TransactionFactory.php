<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_id' => 1,
            'service_id' => 1,
            'transaction_date' => now(),
            'status' => Str::random(10),
            'total_price' => 50000,
            'payment_method' => 'credit_card',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
