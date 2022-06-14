<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/join-atelier', fn() => view('join-atelier'))->name('join-atelier');

/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', fn() => 'dashboard!')->name('dashboard');