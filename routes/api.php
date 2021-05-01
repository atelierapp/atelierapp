<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectForkController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitSystemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-social', [AuthController::class, 'socialLogin']);
Route::post('/sign-up', [AuthController::class, 'signUp'])->name('signUp');

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
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
        Route::post('projects/{project}/fork', ProjectForkController::class)->name('projects.fork');
    }
);

Route::get('colors', [ColorController::class, 'index'])->name('colors.index');

Route::apiResource('categories', CategoryController::class)->names('category');

Route::apiResource('products', ProductController::class)->names('product');

Route::apiResource('materials', MaterialController::class)->names('material');

Route::apiResource('tags', TagController::class)->names('tag');

Route::apiResource('unit', UnitController::class)->names('unit');

Route::apiResource('unit-system', UnitSystemController::class)->names('unit-system');

Route::apiResource('stores', StoreController::class)->names('store');

Route::apiResource('media-types', MediaTypeController::class)->names('media-type');

Route::apiResource('media', MediaController::class)
    ->names('media')
    ->except(['store'])
    ->parameters(['media' => 'media']);

Route::apiResource('rooms', RoomController::class)->names('room');
