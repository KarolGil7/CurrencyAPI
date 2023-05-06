<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAdminRole;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/currency/get-all', [CurrencyController::class, 'getAll']);
    Route::get('/currency/get', [CurrencyController::class, 'get']);

    Route::middleware([CheckAdminRole::class])->group(function () {
        Route::post('/currency/add', [CurrencyController::class, 'add']);
    });
});



