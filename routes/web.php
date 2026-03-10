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
Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/data', [ProductController::class, 'getData'])->name('products.data');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggle-active');
});
