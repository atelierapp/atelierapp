<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectionFeatureController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\Dashboard\NetIncomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManufactureProcessController;
use App\Http\Controllers\ManufactureTypeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\Process\ProductProjectController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFavoriteController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileFavoriteController;
use App\Http\Controllers\ProfileOrderController;
use App\Http\Controllers\ProfileProjectController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectForkController;
use App\Http\Controllers\QualityController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreImpactController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\StoreUserQualifyController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitSystemController;
use App\Http\Controllers\User\ProfilePaymentController;
use App\Http\Controllers\UsernameValidationController;
use App\Http\Controllers\VariationController;
use Illuminate\Support\Facades\Route;

Route::prefix('/paypal')->group(function () {
    Route::get('/generate-order/{order}', [PaypalController::class, 'generateOrder'])->name('paypal.test');
    Route::any('/check-payment', [PaypalController::class, 'checkPayment'])->name('paypal.check-payment');
    Route::any('/notify', [PaypalController::class, 'notify'])->name('paypal.notify');
});

Route::middleware('locale')->group(function () {

    // auth
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-social', [AuthController::class, 'socialLogin']);
    Route::post('/sign-up', [AuthController::class, 'signUp'])->name('signUp');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('/validate-username', UsernameValidationController::class)->name('username.validate');

    // Products
    Route::get('/products/trending', [ProductFavoriteController::class, 'trending'])->name('product.trending');
    Route::get('/products/qualifications', [ProductReviewController::class, 'index'])->name('product.review.index');
    Route::apiResource('products', ProductController::class)->names('product');
    Route::prefix('products/{product}')->group(function () {
        Route::post('favorite', [ProductFavoriteController::class, 'user'])->name('product.favorite');
        Route::post('images', [ProductController::class, 'image'])->name('product.image');
        Route::post('/qualify', [ProductReviewController::class, 'store'])->name('product.review.store');
        Route::get('/reviews', [ProductReviewController::class, 'show'])->name('product.review.show');
        Route::prefix('variations')->group(function () {
            Route::get('/', [VariationController::class, 'index'])->name('variation.index');
            Route::post('/', [VariationController::class, 'store'])->name('variation.store');
            Route::patch('{variation}', [VariationController::class, 'update'])->name('variation.update');
            Route::post('{variation}/images', [VariationController::class, 'image'])->name('variation.image');
            Route::delete('{variation}', [VariationController::class, 'destroy'])->name('variation.destroy');
        });
    });

    // Banners
    Route::apiResource('banners', BannerController::class)->names('banner');
    Route::post('banners/{banner}/image', [BannerController::class, 'image'])->name('banner.image');

    Route::apiResource('qualities', QualityController::class)->names('quality')->except(['show']);

    Route::get('colors', [ColorController::class, 'index'])->name('colors.index');

    Route::apiResource('categories', CategoryController::class)->names('category');

    Route::apiResource('materials', MaterialController::class)->names('material');

    Route::apiResource('tags', TagController::class)->names('tag');

    Route::apiResource('unit', UnitController::class)->names('unit');

    Route::apiResource('unit-system', UnitSystemController::class)->names('unit-system');

    Route::apiResource('media-types', MediaTypeController::class)->names('media-type');

    Route::prefix('resources')->group(function () {
        Route::get('manufacture-type', ManufactureTypeController::class)->name('resources.manufacture-type');
        Route::get('manufacture-process', ManufactureProcessController::class)->name('resources.manufacture-process');
    });

    Route::group(['middleware' => 'optional.sanctum'], function () {

    });

    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);

        // Profile
        Route::prefix('/profile')->group(function () {
            Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::post('/image', [ProfileController::class, 'image'])->name('profile.image');
            Route::post('/terms', [ProfileController::class, 'terms'])->name('profile.terms');
            Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
            Route::get('/favorite-products', ProfileFavoriteController::class)->name('profile.favorites');
            Route::get('/projects', ProfileProjectController::class)->name('profile.projects');
            Route::get('/orders', ProfileOrderController::class)->name('profile.orders');
            Route::apiResource('/payment-gateways', ProfilePaymentController::class)->names('profile.payment-gateway')->only(['store']);
        });

        // Shopping Cart
        Route::get('shopping-cart', [ShoppingCartController::class, 'index'])->name('shopping-cart.index');
        Route::post('shopping-cart/{variationId}/increase', [ShoppingCartController::class, 'increase'])->name('shopping-cart.increase');
        Route::post('shopping-cart/{variationId}/decrease', [ShoppingCartController::class, 'decrease'])->name('shopping-cart.decrease');
        Route::post('shopping-cart/{variationId}/delete', [ShoppingCartController::class, 'remove'])->name('shopping-cart.delete');
        Route::post('shopping-cart/create-order', [ShoppingCartController::class, 'order'])->name('shopping-cart.order');

        // Collections
        Route::apiResource('collections', CollectionController::class)->names('collection')->except(['show']);
        Route::get('/collections/featured', CollectionFeatureController::class)->name('collection.featured');
        Route::post('collections/{collection}/image', [CollectionController::class, 'image'])->name('collection.image');

        // Stores
        Route::get('stores/my-store', [StoreController::class, 'myStore'])->name('store.my-store');
        Route::apiResource('stores', StoreController::class)->names('store');
        Route::post('stores/{store}/image', [StoreController::class, 'image'])->name('store.image');
        Route::get('stores/{store}/products', StoreProductController::class)->name('store.products.index');
        Route::post('stores/{store}/qualify', StoreUserQualifyController::class)->name('store.qualify');
        Route::get('stores/{store}/impact', [StoreImpactController::class, 'index'])->name('store.impact.index');
        Route::post('stores/{store}/impact', [StoreImpactController::class, 'store'])->name('store.impact.store');

        // Projects
        Route::apiResource('projects', ProjectController::class);
        Route::prefix('projects/{project}')->group(function () {
            Route::post('/fork', ProjectForkController::class)->name('project.fork');
            Route::post('/image', [ProjectController::class, 'image'])->name('project.image');
            Route::post('/product', [ProductProjectController::class, 'store'])->name('project.product.store');
        });
        Route::get('projects-temp', [ProjectController::class, 'index']);
        Route::post('projects-temp', [ProjectController::class, 'store']);
        Route::put('projects-temp/{project}', [ProjectController::class, 'update']);

        // Orders
        Route::apiResource('orders', OrderController::class)->names('order')->only(['index', 'update', 'show']);
        Route::get('orders/{order}/details', [OrderDetailController::class, 'index'])->name('order.details');
        Route::post('orders/{order}/accept', [OrderController::class, 'accept'])->name('order.accept');
        Route::patch('orders/{order}/details/{detail}', [OrderDetailController::class, 'update'])->name('order.details.update');

        // Dashboard
        Route::prefix('dashboard')->group(function () {
            Route::get('kpi', [DashboardController::class, 'kpi'])->name('dashboard.kpi-general');
            Route::get('kpi-products', [DashboardController::class, 'kpiProducts'])->name('dashboard.kpi-products');
            Route::get('statics', [DashboardController::class, 'statics'])->name('dashboard.statics');
            Route::get('orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
            Route::get('top-product', [DashboardController::class, 'topProduct'])->name('dashboard.top-product');
            Route::get('net-income', NetIncomeController::class)->name('dashboard.net-income');
            Route::get('quick-details', [DashboardController::class, 'quickDetails'])->name('dashboard.quick-details');
        });
    });
});

Route::post('subscriptions/session', SubscriptionController::class)->name('subscriptions.intent');

Route::apiResource('media', MediaController::class)
    ->names('media')
    ->except(['store'])
    ->parameters(['media' => 'media']);

Route::apiResource('rooms', RoomController::class)->names('room');

Route::get('plans', PlanController::class)->name('plans.index');
