<?php

use App\Http\Controllers\Api\Authcontroller;
use App\Http\Controllers\Api\Categories;
use App\Http\Controllers\Api\Services;
use App\Http\Controllers\SiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;




Route::post('e-check',  [SiteController::class, 'e_check']);
Route::post('e-fund',  [SiteController::class, 'e_fund']);
Route::post('verify-username',  [UserController::class, 'verify_username']);











