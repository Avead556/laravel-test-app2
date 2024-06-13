<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['user.userActivity'])->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
});


Route::middleware(['auth', 'user.userActivity'])->group(function () {
    Route::resource('posts', PostController::class);
    Route::get('currencies', [CurrencyController::class, 'index'])->name('currencies.index');
});
