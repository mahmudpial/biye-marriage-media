<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\CandidateProfile;
use App\Models\MembershipPackage;
use App\Models\SuccessStory;
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

    // Matrimonial Success Stories CMS
    Route::resource('stories', StoryController::class);
    Route::get('/stories/{story}', function (SuccessStory $story) {
        return redirect()->route('admin.stories.edit', $story);
    })->name('stories.show');
    Route::post('/stories/{story}', [StoryController::class, 'update'])->name('stories.update.post');
    Route::match(['POST', 'PATCH'], '/stories/{story}/toggle-active', [StoryController::class, 'toggleActive'])->name('stories.toggle-active');
    Route::match(['POST', 'PATCH'], '/stories/{story}/toggle-featured', [StoryController::class, 'toggleFeatured'])->name('stories.toggle-featured');
    Route::get('/stories/{story}/toggle-active', fn () => redirect()->route('admin.stories.index'));
    Route::get('/stories/{story}/toggle-featured', fn () => redirect()->route('admin.stories.index'));

    // VIP Consultation Requests & Leads CMS
    Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::post('/inquiries/{inquiry}', [InquiryController::class, 'update'])->name('inquiries.update.post');
    Route::match(['POST', 'PATCH'], '/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.update-status');
});
