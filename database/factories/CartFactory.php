<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartFactory extends Factory
{
    public function definition()
    {
        return [
            'productId' => Product::factory()->create(),
            'productName' => $this->faker->word(),
            'quantity' => 1,
            'price' => $this->faker->randomNumber(2),
        ];
    }
}
