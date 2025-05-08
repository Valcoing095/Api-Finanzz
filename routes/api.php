<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Auth\AuthController;

// Grupo con prefijo 'auth' y middleware 'api' (para rutas API)
Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::controller(AuthController::class)->group(function (){
        Route::post('signUp','signUp');
        Route::post('logIn' ,'logIn');
        Route::post('logout','logout');
    });
});

Route::prefix('auth')->group(function () {

    // Rutas públicas
    Route::post('signUp', [AuthController::class, 'signUp']);
    Route::post('logIn', [AuthController::class, 'logIn']);

    // Rutas protegidas por Sanctum
    Route::middleware('auth:sanctum')->controller(AuthController::class)->group(function () {
        Route::post('logout','logout');
    });
});
