<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::Get('logout', [AuthController::class, 'logout']);
        Route::post('search', [ProductController::class, 'search']);//
        Route::Get('show', [ProductController::class, 'show']);//product details
        Route::post('store', [ProductController::class, 'store']);
        Route::get('get-all-category', [CategoryController::class, 'all']);//جميع التصنيفات من النوع get
        Route::post('Add_Category', [CategoryController::class, 'createCategory']);
        Route::get('get-all-product', [ProductController::class, 'get_all_product']);//جميع المنتجات من نوع get
        Route::get('get-all-order', [OrderController::class, 'get_all_Order']);//جميع المنتجات من نوع get
        Route::get('Product_details/{id}', [ProductController::class, 'Product_details']);
        Route::get('get/{id}', [CategoryController::class, 'All_product']);//product  by category
        Route::Get('profile', [AuthController::class, 'profile']);
        Route::post('order', [OrderController::class, 'Order']);
        Route::get('get-order', [OrderController::class, 'get_Order']);
    });

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

