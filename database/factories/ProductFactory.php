<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'product_name' => $this->faker->name(),
            'product_price' => $this->faker->numberBetween($min = 1500, $max = 2000),
            'product_quantity' => $this->faker->numberBetween($min = 1, $max = 10),
        ];
    }
}
