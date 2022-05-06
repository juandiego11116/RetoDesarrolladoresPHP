<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use App\Placetopay\PaymentGatewayContract;
use App\Placetopay\Placetopay;
use Database\Seeders\RolesTableSeeder;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBuyProductInPlaceToPay(): void
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

        $response = $this->actingAs($user)
            ->post(route('payment.store'), ['total' => $product->price]);

        $response->assertRedirect($processUrl);
    }

    public function testResponseFromBuyProductInPlaceToPay(): void
    {
        $this->createSectionForBuyProduct();
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
        $purchase = Purchase::first();

        $consultResponse = ["requestId" => 1,
                            "status"=> [
                                "status" => "APPROVED",
                                "reason" => "00",
                                "message"=> "La petición ha sido aprobada exitosamente",
                                "date" => "2021-11-30T15:49:47-05:00"
                            ]];
        Http::fake(function ($request) use ($consultResponse) {
            return Http::response(json_encode($consultResponse), 200);
        });

        $user = User::first();


        $response = $this->actingAs($user)
            ->get(route('payment.finish', ['reference' => $purchase->reference]));

        $response->assertViewIs('purchases.finish');
    }

    public function createSectionForBuyProduct()
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
    }
}
