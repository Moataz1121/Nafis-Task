<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');





    Route::middleware(['auth:sanctum' , 'admin'])->group(function () {
        Route::apiResource('tasks' , TaskController::class);
        Route::post('assgin/{task}', [TaskController::class, 'assignUsers']);
        Route::get('task/{user}', [TaskController::class, 'getTasksByUser']);
    });

    Route::controller(UserController::class)->group(function(){
        Route::get('users' , 'index')->middleware('auth:sanctum');
    });