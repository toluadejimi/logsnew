<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;




Route::post('efund',  [UserController::class, 'e_fund']);

Route::any('e-check',  'User\UserController@e_check')->name('e-check');

//Route::any('fund',  'SiteController@fund_now')->name('fund');









