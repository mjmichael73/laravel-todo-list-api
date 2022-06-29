<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;



Route::get('/v1/todos', [TodoController::class, 'index']);
Route::post('/v1/todos', [TodoController::class, 'store']);
Route::delete('/v1/todos/{id}', [TodoController::class, 'destroy']);
