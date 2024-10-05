<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

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
    Route::get('admin/profile', [HomeController::class, 'profileSettings'])->name('profile.settings');
    Route::put('admin/profile', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/profile/update-picture', [ProfileController::class, 'profileUpdate'])->name('profile.update_picture');
    Route::get('admin/security', [HomeController::class, 'securitySettings'])->name('security.settings');
    Route::put('profile/update', [ProfileController::Class, 'securityUpdate'])->name('security.update');
    Route::put('profile/security/update', [ProfileController::class, 'changePassword'])->name('changePassword.update');
});
