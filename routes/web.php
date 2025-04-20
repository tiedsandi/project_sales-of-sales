<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

Route::get('/', [AuthController::class, 'login'])->middleware('checkAuth');
Route::post('action-login', [AuthController::class, 'actionLogin']);
Route::get('logout', [AuthController::class, 'logout']);


Route::group(['middleware' => 'checkAuth'], function () {
  Route::get('/dashboard', function () {
    return view('dashboard');
  });
  Route::resource('category', CategoryController::class);
  Route::resource('product', ProductController::class);
  Route::get('pos-sale', [TransactionController::class, 'create']);
  Route::post('pos-sale', [TransactionController::class, 'store'])->name('pos-sale.store');
});
