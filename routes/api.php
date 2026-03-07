<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'getCart'])->name('get');
    Route::post('/add', [CartController::class, 'addItem'])->name('add');
    Route::patch('/items/{cartItem}', [CartController::class, 'updateQuantity'])->name('update');
    Route::delete('/items/{cartItem}', [CartController::class, 'removeItem'])->name('remove');
    Route::delete('/', [CartController::class, 'clearCart'])->name('clear');
});
