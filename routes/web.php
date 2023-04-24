<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\LanguageSwitcherController;
use App\Http\Controllers\LinkStripeStoreController;
use Illuminate\Support\Facades\Route;

Route::get('*', fn () => redirect()->to('https://atelier-app.com'));

Route::get('stripe/connect-store', LinkStripeStoreController::class)->name('stripe.connect-store');
/*
|--------------------------------------------------------------------------
| Landing Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/language/{locale}', LanguageSwitcherController::class)
    ->where('locale', '(en|es){1}')->name('language.switcher');
Route::get('/about', AboutUsController::class)->name('about');
Route::get('/open-your-shop', fn() => view('open-your-shop'))->name('open-your-shop');
Route::get('/privacy-policy', fn () => view('privacy-policy'))->name('privacy-policy');
Route::get('/apple/redirect', fn() => response()->json());
Route::get('/to-app', fn() => redirect(config('atelier.web-app.url')))->name('web-app');

/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Recover Password
|--------------------------------------------------------------------------
*/
Route::get('recover-password', [AuthController::class, 'resetPassword'])->name('resetPassword')->domain('app.' . config('app.url'));
