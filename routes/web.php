<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/product', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('product');

Route::get('/product_detail', [ProductDetailController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('product_detail');

Route::post('/product_detail/qr-code', [ProductDetailController::class, 'generateQr'])->name('product_detail.qr');



Route::get('/product/create', [ProductDetailController::class, 'index'])->name('product.create');
Route::post('/product', [ProductDetailController::class, 'store'])->name('product.store');
//Route::get('/products', [ProductDetailController::class, 'list'])->name('product');  // Or wherever your product list is


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
