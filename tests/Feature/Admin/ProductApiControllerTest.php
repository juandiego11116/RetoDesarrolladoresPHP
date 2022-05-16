<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetJson(): void
    {
        Product::factory()->count(2)->create();
        $response = $this->getJson('api/products');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'price',
                        'stock_number',
                        'id_category',
                        'description',
                        'photo',
                        'visible',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function testGetProduct(): void
    {
        $product = Product::factory()->count(1)->create();
        $response = $this->getJson('api/products');

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
            $json->has('data')
                ->has(
                    'data.0',
                    fn ($json) =>
                $json->where('id', $product->toArray()[0]['id'])
                    ->etc()
                )
            );
    }
    public function testStoreProduct(): void
    {
        $product = Product::factory()->make();

        $response = $this->postJson('api/products/store', [
            'name' => $product->name,
            'price' => $product->price,
            'stock_number' => $product->stock_number,
            'id_category' => $product->id_category,
            'description' => $product->description,
            'photo' => $product->photo,
            'visible' => $product->visible,
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'data' => true,
            ]);

        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id')
        ]);
    }

    public function testUpdateProduct(): void
    {
        $product = Product::factory()->count(1)->create();


        $response = $this->patchJson("api/products/update/{$product->toArray()[0]['id']}", [
            'name' => 'hi',
            'price' => $product->toArray()[0]['price'],
            'stock_number' => $product->toArray()[0]['stock_number'],
            'id_category' => $product->toArray()[0]['id_category'],
            'description' => $product->toArray()[0]['description'],
            'photo' => $product->toArray()[0]['photo'],
            'visible' => $product->toArray()[0]['visible'],
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $response->json('data.id'),
            'name' => $response->json('data.name'),
        ]);
    }

    public function testDestroyProduct(): void
    {
        $product = Product::factory()->create();

        $this->deleteJson("api/products/delete/{$product['id']}");

        $this->assertDatabaseMissing('products', [
            'id' => $product['id'],
        ]);
    }
}
