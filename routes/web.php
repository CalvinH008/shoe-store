<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController as UserProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// guest route untuk yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// route logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// route product untuk user
Route::get('/products', [UserProductController::class, 'index'])->name('products.index');

Route::prefix('cart')->name('cart.')->middleware('auth:web')->group(function () {
    Route::get('/', [CartController::class, 'getCart'])->name('get');
    Route::post('/add', [CartController::class, 'addItem'])->name('add');
    Route::patch('/items/{cartItem}', [CartController::class, 'updateQuantity'])->name('update');
    Route::delete('/items/{cartItem}', [CartController::class, 'removeItem'])->name('remove');
    Route::delete('/', [CartController::class, 'clearCart'])->name('clear');
});

// route admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
    Route::patch('products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggle-active');
});
