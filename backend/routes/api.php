<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatFactController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/tasks', [TaskController::class, 'showTasks']);
    Route::post('/task/create', [TaskController::class, 'createTask']);
    Route::patch('/task/{task}/change/status', [TaskController::class, 'changeStatus']);
    Route::get('/cat-fact', [CatFactController::class, 'getCatFact']);
});

Route::post('/login', [AuthController::class, 'login']);
