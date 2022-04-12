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
            $table->string('reference');
            $table->integer('total');
            $table->string('status');
            $table->string('id_request');
            $table->string('deduct_from_stock');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase');
    }
}
