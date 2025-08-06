<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CartController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::post('/products/{id}/variants', [ProductController::class, 'addVariants']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/cart', [CartController::class, 'store']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::post('/checkout', [CheckoutController::class, 'checkout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

