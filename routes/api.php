<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\QualityController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectForkController;
use App\Http\Controllers\ProjectTempController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitSystemController;
use App\Http\Controllers\UsernameValidationController;
use App\Http\Controllers\VariationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-social', [AuthController::class, 'socialLogin']);
Route::post('/sign-up', [AuthController::class, 'signUp'])->name('signUp');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/validate-username', UsernameValidationController::class)->name('validateUsername');

Route::middleware('auth:sanctum')->group(function () {
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
        Route::post('projects/{project}/image', [ProjectController::class, 'image'])->name('projects.image');

        Route::get('projects-temp', [ProjectTempController::class, 'index']);
        Route::post('projects-temp', [ProjectTempController::class, 'store']);
        Route::put('projects-temp/{project}', [ProjectTempController::class, 'update']);
    }
);

Route::get('colors', [ColorController::class, 'index'])->name('colors.index');

Route::apiResource('categories', CategoryController::class)->names('category');

Route::apiResource('collections', CollectionController::class)->names('collection')->except(['show']);
Route::post('collections/{collection}/image', [CollectionController::class, 'image'])->name('collection.image');

Route::apiResource('products', ProductController::class)->names('product');
Route::prefix('products/{product}')->group(function () {
    Route::post('images', [ProductController::class, 'image'])->name('product.image');
    Route::prefix('variations')->group(function () {
        Route::get('/', [VariationController::class, 'index'])->name('variation.index');
        Route::post('/', [VariationController::class, 'store'])->name('variation.store');
    });
});

Route::apiResource('materials', MaterialController::class)->names('material');

Route::apiResource('tags', TagController::class)->names('tag');

Route::apiResource('qualities', QualityController::class)
    ->names('quality')
    ->except(['show']);

Route::apiResource('unit', UnitController::class)->names('unit');

Route::apiResource('unit-system', UnitSystemController::class)->names('unit-system');

Route::apiResource('stores', StoreController::class)->names('store');
Route::post('stores/{store}/image', [StoreController::class, 'image'])->name('store.image');

Route::apiResource('media-types', MediaTypeController::class)->names('media-type');

Route::apiResource('media', MediaController::class)
    ->names('media')
    ->except(['store'])
    ->parameters(['media' => 'media']);

Route::apiResource('rooms', RoomController::class)->names('room');

Route::apiResource('banners', BannerController::class)->names('banner');
Route::post('banners/{banner}/image', [BannerController::class, 'image'])->name('banner.image');
