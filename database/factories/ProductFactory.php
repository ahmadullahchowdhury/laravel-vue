<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'sku' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'quantity' => $this->faker->numberBetween(0, 1000),
            'category_id' => Category::factory(),
        ];
    }
}