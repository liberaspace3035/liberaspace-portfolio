<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminPortfolioController;
use App\Http\Controllers\Admin\AdminHeroStatController;
use App\Http\Controllers\Admin\AdminServiceController;
use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    Route::get('/login', [AdminPortfolioController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminPortfolioController::class, 'login'])->name('login.post');
    Route::get('/logout', [AdminPortfolioController::class, 'logout'])->name('logout');
    
    Route::middleware(['auth.admin'])->group(function () {
        Route::get('/dashboard', [AdminPortfolioController::class, 'dashboard'])->name('dashboard');
        Route::resource('portfolios', AdminPortfolioController::class);
        Route::resource('hero-stats', AdminHeroStatController::class);
        Route::resource('services', AdminServiceController::class);
    });
});

