<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\ClientController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    // Rutas públicas
    Route::post('signUp', 'signUp');
    Route::post('logIn', 'logIn');
    // Rutas protegidas por Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout','logout');
    });
});

Route::prefix('client')->controller(ClientController::class)->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/newClient','newClient')->name('client.new');
        Route::get('/','getClients')->name('client.getAll');
    });
});
