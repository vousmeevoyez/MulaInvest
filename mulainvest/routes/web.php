<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Page Registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register-form');
// Controller Registrasi
Route::post('/register', [RegisterController::class, 'register'])->name('register-store');

// Page login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login-form');
// Controller Login
Route::post('/login', [LoginController::class, 'login'])->name('login-store');
// Controller Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group([
    'middleware' => 'auth',
], function () {

    Route::group([
        'middleware' => 'admin',
    ], function () {
        // Page CMS
        Route::get('/content-management-system', [AdminController::class, 'showCMS'])->name('content-management-system');
    });

    // Page Home
    
    // Page Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile-page');
    // Page Edit Profile
    Route::get('/edit-profile', [ProfileController::class, 'showEditProfileForm'])->name('edit-profile-form');
    // Controller Edit Profile
    Route::post('/edit-profile', [ProfileController::class, 'updateProfile'])->name('update-profile');

    // Page Edit Password
    Route::get('/edit-password', [ProfileController::class, 'showEditPasswordForm'])->name('edit-password-form');
    // Controller Edit Password
    Route::post('/edit-password', [ProfileController::class, 'updatePassword'])->name('update-password');
});
