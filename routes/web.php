<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

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

// Page Home (User)

// Page CMS
Route::get('/content-management-system', [AdminController::class, 'showCMS'])->name('content-management-system');
