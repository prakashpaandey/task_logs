<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MainTaskController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\StatisticsController;

Route::get('/dashboard', [TaskController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::resource('clients', ClientController::class)->only(['store', 'update', 'destroy'])->names([
        'store' => 'dashboard.clients.store',
        'update' => 'dashboard.clients.update',
        'destroy' => 'dashboard.clients.destroy',
    ]);
    Route::resource('main-tasks', MainTaskController::class)->only(['store', 'update', 'destroy'])->names([
        'store' => 'main-task.store',
        'update' => 'main-task.update',
        'destroy' => 'main-task.destroy',
    ]);
    Route::resource('subtasks', SubTaskController::class)->only(['store', 'update', 'destroy'])->names([
        'store' => 'subtask.store',
        'update' => 'subtask.update',
        'destroy' => 'subtask.destroy',
    ]);
    Route::resource('comments', CommentController::class)->only(['store', 'update', 'destroy'])->names([
        'store' => 'dashboard.comments.store',
        'update' => 'dashboard.comments.update',
        'destroy' => 'dashboard.comments.destroy',
    ]);
    Route::resource('time-logs', TimeLogController::class)->only(['store', 'update', 'destroy'])->names([
        'store' => 'dashboard.time-logs.store',
        'update' => 'dashboard.time-logs.update',
        'destroy' => 'dashboard.time-logs.destroy',
    ]);
    Route::get('statistics', [StatisticsController::class, 'getStatistics'])->name('dashboard.statistics');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
