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
        Route::post('/','store')->name('client.new');
        Route::get('/','index')->name('client.all');
        Route::get('/{client}','show')->name('client.get');
        Route::put('update/{client}','update')->name('client.update');
        Route::delete('delete/{client}','destroy')->name('client.delete');
    });
});
