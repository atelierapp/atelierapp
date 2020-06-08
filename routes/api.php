<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::post('/login', 'AuthController@login');
Route::post('/login-social', 'AuthController@socialLogin');
Route::post('/sign-up', 'AuthController@signUp');

Route::group(['middleware' => 'auth:sanctum'], function () {

    /*
    |----------------------------------------------------------------------
    | Account
    |----------------------------------------------------------------------
    */
    Route::post('/logout', 'AuthController@logout');
    Route::get('/profile', 'ProfileController');

    /*
    |----------------------------------------------------------------------
    | Projects
    |----------------------------------------------------------------------
    */
    Route::apiResource('projects', 'ProjectController');
});

Route::apiResource('categories', 'CategoryController');

Route::apiResource('products', 'ProductController');

Route::apiResource('units', 'UnitController');
