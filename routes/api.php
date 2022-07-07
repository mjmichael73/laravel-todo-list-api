<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthController;


Route::post('/v1/user/register', [AuthController::class, 'register']);
Route::post('/v1/user/login', [AuthController::class, 'login']);

Route::group(['prefix' => '/v1/user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});


Route::group(['prefix' => '/v1/todos', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [TodoController::class, 'index']);
    Route::post('/', [TodoController::class, 'store']);
    Route::delete('/{todo}', [TodoController::class, 'destroy']);
    Route::get('/{todo}', [TodoController::class, 'show']);
    Route::patch('/{todo}', [TodoController::class, 'update']);
    Route::post('/upload', [TodoController::class, 'upload']);
});
