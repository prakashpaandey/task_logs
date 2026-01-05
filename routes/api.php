<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\MainTaskController;
use App\Http\Controllers\API\SubTaskController;
use App\Http\Controllers\API\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('main-tasks', MainTaskController::class);
    Route::apiResource('subtasks', SubTaskController::class);
    Route::apiResource('comments', CommentController::class);
});

// Also provide non-auth versions for easy initial Postman checking if they haven't set up tokens (OPTIONAL, but let's stick to auth for professionalism and maybe a bypass for testing if they ask)
// Actually, I'll add a temporary bypass if they want, but better to show how to use tokens.
// For now, let's keep it under sanctum.
