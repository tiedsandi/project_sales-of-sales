<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::post('/action-login', [LoginController::class, 'actionLogin'])->name('login');
Route::get('logout', [LoginController::class, 'logout']);
