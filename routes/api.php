<?php

use App\Http\Controllers\User\Admin\AdminOrderController;
use App\Http\Controllers\User\Admin\CategorySizePriceController;
use App\Http\Controllers\User\Admin\LocationController;
use App\Http\Controllers\User\Admin\MenuItemController;
use App\Http\Controllers\User\Admin\ProductController;
use App\Http\Controllers\User\Admin\SizeController;
use App\Http\Controllers\User\Admin\UserController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PriceCategoryController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('products', ProductController::class);
Route::apiResource('admin/orders', AdminOrderController::class);
Route::apiResource('users', UserController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('menu-items', MenuItemController::class);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('sizes', SizeController::class);
    Route::apiResource('price_categories', PriceCategoryController::class);
    Route::apiResource('category-size-prices', CategorySizePriceController::class);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{id}', [CartController::class, 'delete']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orders', [OrderController::class, 'completeOrder']);
    Route::get('own-orders', [OrderController::class, 'getOwnOrders']);
    Route::get('/profile', [ProfileController::class, 'getAuthUserProfile']);
    Route::post('/profile/location', [ProfileController::class, 'addLocationInProfile']);
    Route::put('/profile/location/{id}', [ProfileController::class, 'updateAuthUserLocation']);
    Route::patch('/profile/location/{id}', [ProfileController::class, 'updateAuthUserLocation']);
});
