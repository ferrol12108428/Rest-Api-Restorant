<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
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

// Route Product
Route::get('/product', [ProductController::class, 'index']);
Route::post('/product/store', [ProductController::class, 'store']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::patch('/product/{id}/update', [ProductController::class, 'update']);
Route::delete('/product/{id}/delete', [ProductController::class, 'destroy']);

// Route Product Category
Route::get('/product-category', [ProductCategoryController::class, 'index']);
Route::post('/product-category/store', [ProductCategoryController::class, 'store']);
Route::get('/product-category/{id}', [ProductCategoryController::class, 'show']);
Route::patch('/product-category/{id}/update', [ProductCategoryController::class, 'update']);
Route::delete('/product-category/{id}/delete', [ProductCategoryController::class, 'destroy']);

// Route Payment
Route::get('/payment', [PaymentController::class, 'index']);
Route::post('/payment/store', [PaymentController::class, 'store']);
Route::get('/payment/{id}', [PaymentController::class, 'show']);
Route::patch('/payment/{id}/update', [PaymentController::class, 'update']);
Route::delete('/payment/{id}/delete', [PaymentController::class,'destroy']);

// Route Payment Method
Route::get('/payment-method', [PaymentMethodController::class, 'index']);
Route::post('/payment-method/store', [PaymentMethodController::class, 'store']);
Route::get('/payment-method/{id}', [PaymentMethodController::class, 'show']);
Route::patch('/payment-method/{id}/update', [PaymentMethodController::class, 'update']);
Route::delete('/payment-method/{id}/delete', [PaymentMethodController::class, 'destroy']);