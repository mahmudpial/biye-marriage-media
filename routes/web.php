<?php

use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Member\BiodataController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\ProposalController;
use App\Http\Middleware\EnsureUserIsClient;
use Illuminate\Support\Facades\Route;

// Public Matrimony Portal Routes
Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/packages', [FrontController::class, 'packages'])->name('packages');
Route::get('/profiles', [FrontController::class, 'profiles'])->name('profiles');
Route::get('/stories', [FrontController::class, 'stories'])->name('stories');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');

// Client Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [ClientAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [ClientAuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [ClientAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ClientAuthController::class, 'login'])->name('login.submit');
});

Route::match(['GET', 'POST'], '/logout', [ClientAuthController::class, 'logout'])->name('logout');

// VIP Consultation Form Submission
Route::post('/consultation', [FrontController::class, 'submitConsultation'])->name('consultation.submit');

// Stop Impersonation Link (Accessible during admin impersonation session)
Route::get('/impersonate/stop', [AdminClientController::class, 'stopImpersonate'])->name('admin.clients.stop-impersonate');

// Authenticated Client Member Portal Routes
Route::middleware(['auth', EnsureUserIsClient::class])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/biodata', [BiodataController::class, 'edit'])->name('biodata.edit');
    Route::post('/biodata', [BiodataController::class, 'update'])->name('biodata.update');
    Route::post('/biodata/toggle-discreet', [BiodataController::class, 'toggleDiscreet'])->name('biodata.toggle-discreet');

    Route::get('/matches', [DashboardController::class, 'matches'])->name('matches');
    Route::get('/shortlists', [DashboardController::class, 'shortlists'])->name('shortlists');
    Route::post('/shortlists/{candidateProfile}', [DashboardController::class, 'toggleShortlist'])->name('shortlists.toggle');

    Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals');
    Route::post('/proposals/{candidateProfile}', [ProposalController::class, 'send'])->name('proposals.send');
    Route::post('/proposals/{proposal}/respond', [ProposalController::class, 'respond'])->name('proposals.respond');
});
