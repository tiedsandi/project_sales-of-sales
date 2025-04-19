<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->middleware('checkAuth');
Route::post('action-login', [AuthController::class, 'actionLogin']);
Route::get('logout', [AuthController::class, 'logout']);


Route::group(['middleware' => 'checkAuth'], function () {
  Route::get('/dashboard', function () {
    return view('dashboard');
  });
});
