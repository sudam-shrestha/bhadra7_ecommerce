<?php

use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/", [PageController::class, "home"])->name("home");

Route::get('/become-a-merchant', [PageController::class, 'merchant_register'])->name('merchant.register');
Route::post('/become-a-merchant', [PageController::class, 'merchant_register_store'])->name('merchant.register.store');

Route::get('/products', [PageController::class, 'products'])->name('products.index');
Route::get('/products/{product:slug}', [PageController::class, 'product_show'])->name('products.show');


// Auth Routes
Route::get("/login", [AuthController::class, "login"])->name("login");
Route::get('/google/redirect', [AuthController::class, "redirect"])->name('google.redirect');
Route::get('/google/callback', [AuthController::class, "callback"]);


Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout (one order per merchant)
    Route::get('/checkout/{merchant}', [OrderController::class, 'checkout'])->name('checkout.show');
    Route::post('/checkout/{merchant}', [OrderController::class, 'store'])->name('checkout.store');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});
