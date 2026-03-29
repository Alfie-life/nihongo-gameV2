<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Game
    Route::get('/game/{mode}/levels', [GameController::class, 'levels']);
    Route::get('/game/{mode}/{level}/question', [GameController::class, 'nextQuestion']);
    Route::post('/game/{mode}/{level}/answer', [GameController::class, 'answer']);
    Route::post('/game/{mode}/{level}/reset', [GameController::class, 'resetLevel']);

    // Collection
    Route::get('/collection', [GameController::class, 'collection']);
});
