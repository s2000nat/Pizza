<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategorySizePriceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PriceCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

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
    Route::get('orders', [OrderController::class, 'getCartAndLocations']);
    Route::post('orders', [OrderController::class, 'completeOrder']);
    Route::get('own-orders', [OrderController::class, 'getOwnOrders']);
    Route::get('/profile', [ProfileController::class, 'getAuthUserProfile']);
    Route::post('/profile/location', [ProfileController::class, 'addLocationInProfile']);
    Route::put('/profile/location/{id}', [ProfileController::class, 'updateAuthUserLocation']);
    Route::patch('/profile/location/{id}', [ProfileController::class, 'updateAuthUserLocation']);
});
