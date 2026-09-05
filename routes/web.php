<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

// Public Matrimony Portal Routes
Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/packages', [FrontController::class, 'packages'])->name('packages');
Route::get('/profiles', [FrontController::class, 'profiles'])->name('profiles');
Route::get('/stories', [FrontController::class, 'stories'])->name('stories');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');

Route::get('/login', function () {
    return redirect('/?login=1');
})->name('login');

// VIP Consultation Form Submission
Route::post('/consultation', [FrontController::class, 'submitConsultation'])->name('consultation.submit');

