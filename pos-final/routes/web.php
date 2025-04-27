<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/action-login', [LoginController::class, 'actionLogin']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [LoginController::class, 'logout']);
    Route::resource('users', UserController::class);
});
