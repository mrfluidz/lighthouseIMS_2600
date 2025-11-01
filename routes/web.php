<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Invoice
Route::get('/invoice', [InvoiceController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('invoice');

Route::get('/invoice_detail', [InvoiceDetailController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('invoice_detail');

// Products
Route::middleware(['auth', 'verified'])->group(function () {

    // Product Listing
    Route::get('/product', [ProductController::class, 'index'])
        ->name('product');

    // Product Create Form
    Route::get('/product_detail', [ProductDetailController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('product_detail');
    // Store New Product
    Route::post('/product', [ProductDetailController::class, 'store'])
        ->name('product.store');

    // Update Stock
    Route::post('/product/{product}/update-stock', [ProductController::class, 'updateStock'])
        ->name('product.updateStock');

    // Generate QR Code
    Route::get('/product/{product}/qr-code', [ProductController::class, 'generateQr'])
        ->name('product.qr');

    // Optional: Edit & Delete (if you add methods)
    Route::get('/product/{product}/edit', [ProductDetailController::class, 'edit'])
        ->name('product.edit');

    Route::delete('/product/{product}', [ProductDetailController::class, 'destroy'])
        ->name('product.destroy');
});

//Reports
    Route::get('/report', [ReportController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('report');

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
