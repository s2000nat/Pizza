<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\CategorySizePriceController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PriceCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('menu-items', [MenuItemController::class, 'index']);
Route::get('menu-items/{id}', [MenuItemController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart', [CartController::class, 'store']);
    Route::delete('cart/{id}', [CartController::class, 'delete']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orders', [OrderController::class, 'completeOrder']);
    Route::get('own-orders', [OrderController::class, 'getOwnOrders']);
    Route::get('/profile', [ProfileController::class, 'getAuthUserProfile']);
    Route::post('/profile/location', [ProfileController::class, 'addLocationInProfile']);
    Route::put('/profile/location/{id}', [ProfileController::class, 'updateAuthUserLocation']);
    Route::patch('/profile/location/{id}', [ProfileController::class, 'updateAuthUserLocation']);

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::apiResource('admin/users', UserController::class);
        Route::apiResource('admin/sizes', SizeController::class);
        Route::apiResource('admin/price-categories', PriceCategoryController::class);
        Route::apiResource('admin/category-size-prices', CategorySizePriceController::class);
        Route::apiResource('admin/locations', LocationController::class);
        Route::apiResource('admin/products', ProductController::class);
        Route::apiResource('admin/orders', AdminOrderController::class);
        Route::put('admin/menu-items/{id}', [MenuItemController::class, 'update']);
        Route::patch('admin/menu-items/{id}', [MenuItemController::class, 'update']);
        Route::post('admin/menu-items', [MenuItemController::class, 'store']);
        Route::delete('admin/menu-items/{id}', [MenuItemController::class, 'destroy']);
    });
});
