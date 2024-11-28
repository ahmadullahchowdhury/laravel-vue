<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::get('products/search', [ProductController::class, 'search']);
Route::apiResource('products', ProductController::class);

Route::get('/search', [ProductController::class, 'search']);



