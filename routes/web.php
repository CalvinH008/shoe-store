<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProductController as UserProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// untuk user biasa
Route::get('/products', [UserProductController::class, 'index'])->name('products.index');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
    Route::patch('products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggle-active');
});
