<?php

namespace Tests\Feature\Payment;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testHomeViewResponseOk(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('home');
    }

    public function testAddProductToCart(): void
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->assignRole('customer');

        $response = $this->actingAs($user)
            ->get(route('cart.addToCart', [
                'productId' => $product->id,
                'quantity' => 1
                ]));

        $response->assertRedirect();
        $this->assertEquals($product->id, Cart::content()->first()->id);
    }

    public function testViewProductShowResponseOk(): void
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->assignRole('customer');

        $response = $this->actingAs($user)
            ->get(route('cart.show', ['productId' => $product->id]));

        $response->assertOk();
        $response->assertViewIs('show');
        $this->assertEquals($product->id, $response['product'][0]->id);
    }

    public function testShowProductInCart(): void
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        Product::factory()->count(5)->create();
        $user->assignRole('customer');
        $product = Product::first();
        $this->actingAs($user)
            ->get(route('cart.addToCart', [
                'productId' => $product->id,
                'quantity' => 1
            ]));

        $response = $this->actingAs($user)
            ->get(route('cart.index'));

        $response->assertOk();
        $response->assertViewIs('cart');
        $this->assertEquals($product->id, $response['products']['027c91341fd5cf4d2579b49c4b6a90da']->id);
    }

    public function testRemoveProductFromCart(): void
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $product = Product::factory()->count(2)->create();
        $user->assignRole('customer');

        Cart::add([
            'id' => $product[0]->id,
            'name' => $product[0]->name,
            'qty' => 1,
            'price' => $product[0]->price,
        ]);
        Cart::add([
            'id' => $product[1]->id,
            'name' => $product[1]->name,
            'qty' => 1,
            'price' => $product[1]->price,
        ]);


        $cart = Cart::content();

        $response = $this->actingAs($user)
            ->post(route('cart.delete'), ['rowId' => $cart['027c91341fd5cf4d2579b49c4b6a90da']->rowId]);

        $response->assertRedirect();
        $this->assertNotEquals($cart['products']['027c91341fd5cf4d2579b49c4b6a90da']->rowId, $cart['027c91341fd5cf4d2579b49c4b6a90da']->rowId);
    }

    public function testUpdateProductFromCart(): void
    {
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $product = Product::factory()->count(5)->create();
        $user->assignRole('customer');

        $this->actingAs($user)
            ->get(route('cart.addToCart', [
                'productId' => $product[0]->id,
                'quantity' => 1
            ]));
        $this->actingAs($user)
            ->get(route('cart.addToCart', [
                'productId' => $product[1]->id,
                'quantity' => 1
            ]));

        $cart = $this->actingAs($user)
            ->get(route('cart.index'));

        $response = $this->actingAs($user)
            ->post(route('cart.update.up'), [
                'rowId' => $cart['products']['027c91341fd5cf4d2579b49c4b6a90da']->rowId,
                'quantity' => 1,
            ]);

        $response->assertRedirect();
    }
}
