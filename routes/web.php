<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestimonialsController;
use Illuminate\Support\Facades\Route;

// Redirect root ke /login
Route::redirect('/', '/home');


// AUTH ROUTES
Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.action');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register')->name('register.action');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});


// PUBLIC
Route::get('/home', fn () => view('pages.home'))->name('home');
Route::get('/meal-plans', [MealPlanController::class, 'index'])->name('meal-plans');
Route::get('/testimonials',[TestimonialsController::class, 'index'])->name('testimonials');


// PROTECTED ROUTES (CUSTOMER)
Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::post('/testimonials', [TestimonialsController::class, 'store'])->name('testimonials.store');
    Route::get('/subscription', [SubscriptionController::class, 'create'])->name('subscription');
    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe.store');

});


// PROTECTED ROUTES (ADMIN)
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/pages/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

