<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\CandidateProfile;
use App\Models\MembershipPackage;
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
    Route::match(['GET', 'POST'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // Matrimonial Candidate Profiles Management
    Route::resource('profiles', ProfileController::class);
    Route::get('/profiles/{profile}', function (CandidateProfile $profile) {
        return redirect()->route('admin.profiles.edit', $profile);
    })->name('profiles.show');
    Route::post('/profiles/{profile}', [ProfileController::class, 'update'])->name('profiles.update.post');
    Route::match(['POST', 'PATCH'], '/profiles/{profile}/toggle-active', [ProfileController::class, 'toggleActive'])->name('profiles.toggle-active');
    Route::match(['POST', 'PATCH'], '/profiles/{profile}/toggle-featured', [ProfileController::class, 'toggleFeatured'])->name('profiles.toggle-featured');
    Route::get('/profiles/{profile}/toggle-active', fn () => redirect()->route('admin.profiles.index'));
    Route::get('/profiles/{profile}/toggle-featured', fn () => redirect()->route('admin.profiles.index'));

    // Membership Packages & Pricing CMS
    Route::resource('packages', PackageController::class);
    Route::get('/packages/{package}', function (MembershipPackage $package) {
        return redirect()->route('admin.packages.edit', $package);
    })->name('packages.show');
    Route::post('/packages/{package}', [PackageController::class, 'update'])->name('packages.update.post');
    Route::match(['POST', 'PATCH'], '/packages/{package}/toggle-active', [PackageController::class, 'toggleActive'])->name('packages.toggle-active');
    Route::match(['POST', 'PATCH'], '/packages/{package}/toggle-featured', [PackageController::class, 'toggleFeatured'])->name('packages.toggle-featured');
    Route::get('/packages/{package}/toggle-active', fn () => redirect()->route('admin.packages.index'));
    Route::get('/packages/{package}/toggle-featured', fn () => redirect()->route('admin.packages.index'));
});
