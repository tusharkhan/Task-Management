<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('home');

Route::get('login', [App\Http\Controllers\Front\Auth\AuthController::class, 'showLoginForm'])->name('login');

Route::get("register", [App\Http\Controllers\Front\Auth\AuthController::class, 'showRegisterForm'])->name('register');
