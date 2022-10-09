<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post("login", [LoginController::class, '__invoke']);
Route::get('/news', [NewsController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    Route::get('/news/create', [NewsController::class, 'create']);
    Route::post('/news/create', [NewsController::class, 'store']);
    Route::get('/news/{id}', [NewsController::class, 'show']);
    Route::get('/news/edit/{id}', [NewsController::class, 'edit']);
    Route::put('/news/edit/{news}', [NewsController::class, 'update']);
    Route::delete('/news/{news}', [NewsController::class, 'destroy']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/category/create', [CategoryController::class, 'create']);
    Route::post('/category/create', [CategoryController::class, 'store']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::put('/category/edit/{category}', [CategoryController::class, 'update']);
    Route::delete('/category/{category}', [CategoryController::class, 'destroy']);

    Route::get('/profiles', [ProfileController::class, 'index']);
    Route::post('/profile/create', [ProfileController::class, 'store']);
    Route::put('/profile/edit/{profile}', [ProfileController::class, 'update']);
    Route::delete('/profile/{profile}', [ProfileController::class, 'destroy']);

    Route::get('/links', [LinkController::class, 'index']);
    Route::post('/link/create', [LinkController::class, 'store']);
    Route::put('/link/edit/{link}', [LinkController::class, 'update']);
    Route::delete('/link/{link}', [LinkController::class, 'destroy']);

    Route::get('/regions', [RegionController::class, 'index']);
    Route::post('/region/create', [RegionController::class, 'store']);
    Route::put('/region/edit/{region}', [RegionController::class, 'update']);
    Route::delete('/region/{region}', [RegionController::class, 'destroy']);

    Route::post('/user/create', [UserController::class, 'store']);
});
