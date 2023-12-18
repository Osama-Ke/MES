<?php

namespace Database\Factories;

use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<product>
 */
class productFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'price' => fake()->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
            'description' => fake()->sentence,
            'note' => fake()->text,
            'amount' => fake()->numberBetween($min = 1, $max = 100),
            'category_id' => fake()->randomNumber(1, 10),
            'is_published' => fake()->boolean ,

        ];
    }
}
