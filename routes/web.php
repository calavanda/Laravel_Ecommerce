<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// ==========================================
// Rutas Públicas y de Clientes (Sincronizadas con Clerk)
// ==========================================
Route::middleware(['clerk'])->group(function () {
    // Rutas de Catálogo de Productos
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

    // Rutas del Carrito de Compras
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    // Rutas de Checkout y Pedidos
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{tracking_number}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/invoice/{tracking_number}', [CheckoutController::class, 'invoice'])->name('checkout.invoice');
});

// ==========================================
// Rutas Administrativas (Protegidas)
// ==========================================
Route::middleware(['clerk', 'clerk.admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Productos (Catálogo)
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products.index');
    Route::post('/product', [AdminController::class, 'storeProduct'])->name('admin.product.store');
    Route::post('/product/{id}/stock', [AdminController::class, 'updateStock'])->name('admin.product.update-stock');
    Route::put('/product/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::delete('/product/{id}', [AdminController::class, 'destroyProduct'])->name('admin.product.destroy');
    
    // Categorías
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
    
    // Pedidos
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders.index');
    Route::post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    Route::delete('/orders/{id}', [AdminController::class, 'destroyOrder'])->name('admin.orders.destroy');
    
    // Administradores
    Route::post('/admins', [AdminController::class, 'storeAdmin'])->name('admin.admins.store');
    Route::delete('/admins/{id}', [AdminController::class, 'removeAdmin'])->name('admin.admins.remove');
    
    // Notificaciones
    Route::post('/notifications/read', [AdminController::class, 'markNotificationsRead'])->name('admin.notifications.read');
});
