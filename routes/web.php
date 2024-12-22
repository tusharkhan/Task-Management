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

Route::get('email/verify/{token}', [App\Http\Controllers\Front\Auth\AuthController::class, 'verifyEmail'])->name('email.verify');


Route::get('/mailable', function () {
    $user = App\Models\User::find(4);
    $data = [
        'user' => $user,
        'link' => route('email.verify', "sefsefsefsef") ,
        'expires_at' => '2024-12-21 00:00:00',
        'brand_name' => config('app.name')
    ];

    return new App\Mail\RegistrationVerificationMail($data);
});
