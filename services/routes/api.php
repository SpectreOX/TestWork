<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/data', [HomeController::class, 'index']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('books', BookController::class);

    Route::post('/logout',  [UserController::class, 'logout'])->name('logout');

});

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login',  [UserController::class, 'login'])->name('login');
