<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Auth\AuthController;

Route::group(['prefix' => 'auth', 'middleware' => 'cors'],function(){
    Route::post('login', [AuthController::class, 'login']);

});
