<?php

namespace Database\Factories;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_category_id' => ServiceCategory::factory(),
            'code' => fake()->randomNumber(),
            'name' => fake()->word(),
            'image' => fake()->imageUrl(),
            'price_A' => fake()->randomFloat(2, 0, 20000),
            'price_B' => fake()->randomFloat(2, 0, 20000),
        ];
    }
}
