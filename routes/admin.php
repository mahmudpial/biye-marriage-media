<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
|
| Dedicated routes for Biye Marriage Media Admin Portal.
| All routes in this file are prefixed with '/admin' and named with 'admin.'.
|
*/

// Guest Routes (Login form & authentication)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Authenticated & Verified Admin Protected Routes
Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Matrimonial Candidate Profiles Management
    Route::resource('profiles', ProfileController::class)->except(['show']);
    Route::patch('/profiles/{profile}/toggle-active', [ProfileController::class, 'toggleActive'])->name('profiles.toggle-active');
    Route::patch('/profiles/{profile}/toggle-featured', [ProfileController::class, 'toggleFeatured'])->name('profiles.toggle-featured');
});
