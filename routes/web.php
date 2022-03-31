<?php

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

Route::get('/', [WelcomeController::class, 'index']);

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

    //user

});

Route::group(['middleware' => ['auth', 'role:customer']], function () {
    Route::get('history', [PaymentController::class, 'history'])->name('payment.history');
    Route::get('payment/{payment}/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('purchases/cart', [PurchaseController::class, 'addToCart'])->name('purchases.addToCart');
    Route::get('purchases', [PurchaseController::class, 'cart'])->name('purchases.cart');
    Route::resource('payment', PaymentController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::get('purchases/show/{productId}', [PurchaseController::class, 'show'])->name('purchases.show');
});


