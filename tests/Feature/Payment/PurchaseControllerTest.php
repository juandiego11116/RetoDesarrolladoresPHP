<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowPurchaseView(): void
    {
        $this->createSectionAndBuyProduct();
        $user = User::first();
        $purchase = Purchase::first();

        $response = $this->actingAs($user)
            ->get(route('purchases.show', ['purchase' => $purchase->id]));

        $response->assertViewIs('purchases.show');
    }

    public function testHistoryPurchasesView(): void
    {
        $this->createSectionAndBuyProduct();

        $user = User::first();

        $response = $this->actingAs($user)
            ->get(route('payment.history'));

        $response->assertViewIs('purchases.history');
    }

    public function createSectionAndBuyProduct(): void
    {
        $processUrl = 'https://checkout-co.placetopay.com/session/1/cc9b8690b1f7228c78b759ce27d7e80a';
        $payResponse = [
            "status" => [
                "status" => "OK",
                "reason"=> "PC",
                "message"=> "La petición se ha procesado correctamente",
                "date" => "2021-11-30T15:08:27-05:00"
            ],
            "requestId" => 1,
            "processUrl" => $processUrl,
        ];

        Http::fake(function ($request) use ($payResponse) {
            return Http::response(json_encode($payResponse), 200);
        });
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $user->assignRole('customer');
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
        ]);

        $this->actingAs($user)
            ->post(route('payment.store'), ['total' => $product->price]);
    }
}
