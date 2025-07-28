<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('menu', App\Http\Controllers\MenuController::class)->only(['index', 'show']);
    Route::resource('cart', App\Http\Controllers\CartController::class);
    Route::post('cart/add/{menuItem}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
// In web.php
    Route::get('cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart/process-checkout', [App\Http\Controllers\CartController::class, 'processCheckout'])->name('cart.process-checkout');
    Route::resource('reservations', App\Http\Controllers\ReservationController::class);
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/menu', App\Http\Controllers\Admin\MenuController::class)->names('admin.menu');
    Route::resource('/reservations', App\Http\Controllers\Admin\ReservationController::class)->names('admin.reservations');
});

// SPA route
Route::get('/spa', function() {
    return view('spa');
})->name('spa');
