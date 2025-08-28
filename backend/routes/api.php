<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;

//Public Routes
Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);

//Protected Routes
Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('orders', OrderController::class);
    Route::post('logout', [AuthController::class,'logout']);
});
