<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomNumber(2),
            'stock_number' => $this->faker->randomNumber(2),
            'id_category' => '1',
            'description' => $this->faker->word(),
            'photo' => $this->faker->image(storage_path('app/public')),
            'visible' => 'true',
        ];
    }
}
