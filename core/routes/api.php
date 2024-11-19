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











