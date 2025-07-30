<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function() {
    Route::resource('menu', App\Http\Controllers\MenuController::class)->only(['index', 'show']);
Route::get('/menu/search', [MenuController::class, 'search'])->name('menu.search');
    Route::resource('cart', App\Http\Controllers\CartController::class);
    Route::post('cart/add/{menuItem}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
// In web.php
    Route::get('cart-user/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.user.checkout');
    Route::post('cart-user/process-checkout', [App\Http\Controllers\CartController::class, 'processCheckout'])->name('cart.user.process-checkout');
    Route::resource('reservations', App\Http\Controllers\ReservationController::class);
    Route::resource('orders', App\Http\Controllers\OrderController::class);
     Route::get('my-orders', [OrderController::class, 'index'])->name('my.order.index');
    Route::get('my-orders/{order}/ajax', [OrderController::class, 'show'])->name('my.order.show');
});

// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function() {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/menu', App\Http\Controllers\Admin\MenuController::class)->names('admin.menu');
    Route::resource('/reservations', App\Http\Controllers\Admin\ReservationController::class)->names('admin.reservations');
        Route::resource('/orders', App\Http\Controllers\Admin\OrderController::class)->names('admin.orders');
});

// SPA route
Route::get('/spa', function() {
    return view('spa');
})->name('spa');
