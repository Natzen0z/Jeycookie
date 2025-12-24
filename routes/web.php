<?php

use Illuminate\Support\Facades\Route;

# ==============================
# User Controllers
# ==============================
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

# ==============================
# Admin Controllers
# ==============================
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminTransactionController;

# ==============================
# USER ROUTES
# ==============================

# Homepage
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

# Our Product (list produk)
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

# Detail produk
Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.show');

# ==============================
# CART ROUTES
# ==============================

# Lihat keranjang
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

# Tambah produk ke keranjang
Route::post('/cart/add', [CartController::class, 'add'])
    ->name('cart.add');

# ==============================
# CHECKOUT ROUTES
# ==============================

# Halaman checkout
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

# Proses buat pesanan
Route::post('/checkout/process', [CheckoutController::class, 'process'])
    ->name('checkout.process');

# ==============================
# ADMIN ROUTES
# ==============================

Route::prefix('admin')->name('admin.')->group(function () {

    # Dashboard admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    # ==========================
    # Admin - Produk
    # ==========================

    Route::get('/products', [AdminProductController::class, 'index'])
        ->name('products.index');

    Route::get('/products/create', [AdminProductController::class, 'create'])
        ->name('products.create');

    Route::post('/products/store', [AdminProductController::class, 'store'])
        ->name('products.store');

    # ==========================
    # Admin - Transaksi
    # ==========================

    Route::get('/transactions', [AdminTransactionController::class, 'index'])
        ->name('transactions.index');

    Route::get('/transactions/{id}', [AdminTransactionController::class, 'show'])
        ->name('transactions.show');
});
