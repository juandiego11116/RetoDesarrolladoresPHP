<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('id_product');
            $table->string('id_request');
            $table->integer('price');
            $table->integer('amount');
            $table->string('status');
            $table->string('reference');
            $table->string('deduct_from_stock');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase');
    }
}
