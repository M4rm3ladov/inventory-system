<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\ItemCategory;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_category_id' => ItemCategory::factory(),
            'brand_id' => Brand::factory(),
            'unit_id' => Unit::factory(),
            'code' => fake()->randomNumber(),
            'name' => fake()->word(),
            'description' => fake()->word(),
            'image' => fake()->imageUrl(),
            'unit_price' => fake()->randomFloat(2, 0, 20000),
            'price_A' => fake()->randomFloat(2, 0, 20000),
            'price_B' => fake()->randomFloat(2, 0, 20000),
        ];
    }
}
