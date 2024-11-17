<?php

use App\Http\Controllers\Api\Authcontroller;
use App\Http\Controllers\Api\Categories;
use App\Http\Controllers\Api\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;




Route::post('e-check',  [UserController::class, 'e_check']);
Route::post('e-fund',  [UserController::class, 'e_fund']);
Route::post('verify-username',  [UserController::class, 'verify_username']);



//API

Route::post('get-token',  [Authcontroller::class, 'get_token']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('get-categories',  [Categories::class, 'get_categories']);
    Route::get('get-all-products',  [Services::class, 'get_all_products']);
    Route::get('get-products-by-category',  [Services::class, 'get_products_by_category']);
    Route::post('buy-product',  [Services::class, 'buy_product']);





});







