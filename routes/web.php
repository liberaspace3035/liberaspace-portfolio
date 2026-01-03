<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminPortfolioController;
use App\Http\Controllers\Admin\AdminHeroStatController;
use App\Http\Controllers\Admin\AdminServiceController;
use Illuminate\Support\Facades\Route;

// Health check endpoint (no database required)
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()], 200);
});

// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    // Redirect /admin/ to /admin/login or /admin/dashboard
    Route::get('/', function () {
        if (session('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });
    
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

