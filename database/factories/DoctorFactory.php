<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);
        return [
            //
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
            'phone' => fake()->numberBetween(1000000000, 9999999999),
            'address' => fake()->address(),
            'photo' => fake()->imageUrl(),
            'description' => fake()->paragraph(),
            'specialist' => fake()->word(),
            'gender' => $gender,
        ];
    }
}
