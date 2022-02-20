<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomNumber(2),
            'stock_number' => $this->faker->randomNumber(2),
            'category' => $this->faker->word(),
            'description' => $this->faker->word(),
            'photo' => $this->faker->image(storage_path('app/public')),
        ];
    }
}
