<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController as UserProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProducts = \App\Models\Product::with('primaryImage')
        ->where('is_active', true)
        ->whereHas('primaryImage')
        ->latest()
        ->take(8)
        ->get();
    return view('welcome', compact('featuredProducts'));
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

// route view cart 
Route::get('/cart', [CartController::class, 'cartPage'])->name('cart.page')->middleware('auth');

// API cart
Route::prefix('cart')->name('cart.')->middleware('auth:web')->group(function () {
    Route::get('/data', [CartController::class, 'getCart'])->name('get');
    Route::post('/add', [CartController::class, 'addItem'])->name('add');
    Route::patch('/items/{cartItem}', [CartController::class, 'updateQuantity'])->name('update');
    Route::delete('/items/{cartItem}', [CartController::class, 'removeItem'])->name('remove');
    Route::delete('/', [CartController::class, 'clearCart'])->name('clear');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkoutPage'])->name('checkout');
    Route::post('/checkout',           [OrderController::class, 'checkout'])->name('checkout.process');
    Route::get('/orders',              [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/{id}/modal', [OrderController::class, 'showModal'])->name('orders.modal');
    Route::get('/orders/{id}',         [OrderController::class, 'show'])->name('orders.show');
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
