<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //crear longitud
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('document_type');//crear tabla
            $table->string('document');
            $table->string('country');//crear tabla tambien estado y ciudad
            $table->string('address');
            $table->string('phone_number');//cambiar (_) y agregar 3 caracteres del pais
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
