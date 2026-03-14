<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Metadata\Group;

// route public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// route product public
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// protected route
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // cart
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'getCart']);
        Route::post('/add', [CartController::class, 'addItem']);
        Route::patch('/items/{cartItem}', [CartController::class, 'updateQuantity']);
        Route::delete('/items/{cartItem}', [CartController::class, 'removeItem']);
        Route::delete('/', [CartController::class, 'clearCart']);
    });

    // orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/checkout', [OrderController::class, 'checkout']);
});
