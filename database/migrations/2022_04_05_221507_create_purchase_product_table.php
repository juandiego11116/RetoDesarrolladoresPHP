<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseProductTable extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_product', function (Blueprint $table) {
            $table->integer('amount');
            $table->integer('price');
            $table->integer('subtotal');
            $table->integer('purchase_id');
            $table->integer('product_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_product');
    }
}
