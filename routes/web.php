<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::resource('products', ProductController::class);
    Route::patch('products/{product}/toggle-active', [ProductController::class, 'toggle-active'])->name('products/toggle-active');
});
