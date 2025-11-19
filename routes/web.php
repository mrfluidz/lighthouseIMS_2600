<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Invoice & Invoice Wizard Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Invoice list page
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice');

    // Store new invoice (if not using wizard)
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');

    // Invoice wizard page
    Route::get('/invoice_detail', [InvoiceDetailController::class, 'index'])->name('invoice_detail');

    Route::get('/invoice-detail', [InvoiceDetailController::class, 'index'])->name('invoice.detail');
    Route::post('/invoice/save-draft', [InvoiceDetailController::class, 'saveDraft'])->name('invoice.saveDraft');
    Route::post('/invoice/item/{invoice}', [InvoiceDetailController::class, 'addItem']);
    Route::delete('/invoice/item/{itemId}', [InvoiceDetailController::class, 'deleteItem']);

   
});

// Product Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Fetch all products (for AJAX search)
    Route::get('/product', [ProductController::class, 'index'])->name('product');

    // Product detail page
    Route::get('/product_detail', [ProductDetailController::class, 'index'])->name('product_detail');

    // Store new product
    Route::post('/product', [ProductDetailController::class, 'store'])->name('product.store');

    // Update product stock
    Route::post('/product/{product}/update-stock', [ProductController::class, 'updateStock'])->name('product.updateStock');

    // Generate QR code for product
    Route::get('/product/{product}/qr-code', [ProductController::class, 'generateQr'])->name('product.qr');

    // Edit product
    Route::get('/product/{product}/edit', [ProductDetailController::class, 'edit'])->name('product.edit');

    // Delete product
    Route::delete('/product/{product}', [ProductDetailController::class, 'destroy'])->name('product.destroy');
});

// Reports
Route::get('/report', [ReportController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('report');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';
