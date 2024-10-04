<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public route for the welcome page
Route::get('/', function () {
    return view('home');
});



// Authentication routes (register, login, etc.)
Route::controller(AuthController::class)->group(function () {
    // Register routes
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    // Login routes
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    
    // Logout route (typically a POST request)
    Route::post('logout', 'logout')->name('logout');
});

// User dashboard (protected with middleware)
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
});

// Admin dashboard (protected with middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/home', [HomeController::class, 'adminIndex'])->name('admin/home');
});
