<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/products', [App\Http\Controllers\Api\ProductController::class, 'index']);
Route::post('/products/store', [App\Http\Controllers\Api\ProductController::class, 'store']);
Route::patch('/products/update/{id}', [App\Http\Controllers\Api\ProductController::class, 'update']);
Route::delete('/products/delete/{id}', [App\Http\Controllers\Api\ProductController::class, 'destroy']);
