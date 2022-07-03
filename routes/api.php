<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;





Route::group(['prefix' => '/v1/todos'], function() {
    Route::get('/', [TodoController::class, 'index']);
    Route::post('/', [TodoController::class, 'store']);
    Route::delete('/{todo}', [TodoController::class, 'destroy']);
    Route::get('/{todo}', [TodoController::class, 'show']);
    Route::patch('/{todo}', [TodoController::class, 'update']);
    Route::post('/upload', [TodoController::class, 'upload']);
});
