<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\SeederTablePermissions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSaveProductResponseOk()
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $file = UploadedFile::fake()->image('avatar.jpg');
        $user = User::factory()->create();
        $product = Product::factory()->make();
        $user->assignRole('admin');
        $user->givePermissionTo('create-product');

        $response = $this->actingAs($user)
            ->post(route('products.store'), [
                'name' => $product->name,
                'price' => $product->price,
                'stock_number' => $product->stock_number,
                'id_category' => $product->id_category,
                'description' => $product->description,
                'photo' => $file,
                'visible' => $product->visible,
            ]);

        $response->assertRedirect();
    }

    public function testCreateProductResponseOk()
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);

        $user = User::factory()->create();

        $user->assignRole('admin');
        $user->givePermissionTo('create-product');

        $response = $this->actingAs($user)
            ->get(route('products.create'));

        $response->assertViewIs('products.create');
    }

    public function testIndexProductsInIndex()
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        Product::factory()->create();
        $user->assignRole('admin');
        $user->givePermissionTo('show-product');

        $response = $this->actingAs($user)
            ->get(route('products.index'));

        $response->assertViewIs('products.index');
    }

    public function testUpdateProductResponseOk()
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $user->assignRole('admin');
        $user->givePermissionTo('edit-product');

        $response = $this->actingAs($user)
            ->patch(route('products.update', $product), [
                'name' => $product->name,
                'price' => $product->price,
                'stock_number' => 30,
                'id_category' => $product->id_category,
                'description' => $product->description,
                'photo' => $product->photo,
                'visible' => $product->visible,
            ]);

        $response->assertRedirect(route('products.index'));
    }

    public function testGoToViewEditProduct(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $product = Product::factory()->create();
        $user = User::factory()->create();

        $user->assignRole('admin');
        $user->givePermissionTo('edit-product');

        $response = $this->actingAs($user)
            ->get(route('products.edit', ['product' => $product]));

        $response->assertViewIs('products.edit');
        $this->assertEquals($product->id, $response['product']->id);
    }

    public function testForDeleteProduct(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $product = Product::factory()->create();
        $user = User::factory()->create();

        $user->assignRole('admin');
        $user->givePermissionTo('delete-product');

        $response = $this->actingAs($user)
            ->delete(route('products.destroy', ['product' => $product]));

        $response->assertRedirect(route('products.index'));
    }
}
