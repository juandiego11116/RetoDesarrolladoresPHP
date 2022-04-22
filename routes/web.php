<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});

Route::group(['middleware' => ['auth', 'role:customer']], function () {
    Route::get('history', [PurchaseController::class, 'history'])->name('payment.history');
    Route::get('payment/{payment}/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('cart.addToCart', [CartController::class, 'store'])->name('cart.addToCart');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('show', [CartController::class, 'show'])->name('cart.show');
    Route::get('count', [CartController::class, 'count'])->name('cart.count');
    Route::post('update', [CartController::class, 'update'])->name('cart.update.up');
    Route::post('delete', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('store.again', [PaymentController::class, 'storeAgain'])->name('payment.store.again');
    Route::resource('payment', PaymentController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::get('cart/show/{productId}', [CartController::class, 'show'])->name('cart.show');
});
