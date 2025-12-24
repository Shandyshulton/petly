<?php

namespace Database\Factories;

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
            'product_name' => fake()->sentence(1),
            'product_desc' => fake()->paragraph(10),
            'product_type' => fake()->randomElement(['food', 'accessories', 'medicine']),
            'product_stock' => fake()->numberBetween(1, 100),
            'product_price' => fake()->randomNumber(5,true),
            'product_rating'=> fake()->numberBetween(1, 10),
            'product_image' => fake()->imageUrl(640, 480, 'animals', true)
        ];
    }
}
