<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkStripeStoreController;
use Illuminate\Support\Facades\Route;

Route::get('stripe/connect-store', LinkStripeStoreController::class)->name('stripe.connect-store');
/*
|--------------------------------------------------------------------------
| Landing Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/open-your-shop', fn() => view('open-your-shop'))->name('open-your-shop');
Route::get('/privacy-policy', fn () => view('privacy-policy'))->name('privacy-policy');
Route::get('/apple/redirect', fn() => response()->json());
Route::get('/to-app', fn() => redirect(config('atelier.web-app.url')))->name('web-app');

/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', fn() => 'dashboard!')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Recover Password
|--------------------------------------------------------------------------
*/
Route::get('recover-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
