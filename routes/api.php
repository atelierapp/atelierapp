<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-social', [AuthController::class, 'socialLogin']);
Route::post('/sign-up', [AuthController::class, 'signUp']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    /*
    |----------------------------------------------------------------------
    | Account
    |----------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', ProfileController::class);

    /*
    |----------------------------------------------------------------------
    | Projects
    |----------------------------------------------------------------------
    */
    Route::apiResource('projects', ProjectController::class);
});

//Route::apiResource('categories', 'CategoryController');
//
//Route::apiResource('products', 'ProductController');
//
//Route::apiResource('units', 'UnitController');

Route::get('colors', [ColorController::class, 'index'])->name('colors.index');
