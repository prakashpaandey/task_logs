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
    Route::get('account/status', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'checkStatus'])->name('dashboard.account.status');
    
    // Temporary Migration Helper
    Route::get('run-migrations-system-admin', function() {
        if (!auth()->check() || !auth()->user()->isAdmin()) abort(403);
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return 'Migrations completed successfully: ' . \Illuminate\Support\Facades\Artisan::output();
    });
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
    Route::post('main-tasks/{main_task}/comments', [\App\Http\Controllers\MainTaskCommentController::class, 'store'])->name('main-task.comments.store');
    Route::put('main-tasks/comments/{comment}', [\App\Http\Controllers\MainTaskCommentController::class, 'update'])->name('main-task.comments.update');
    Route::delete('main-tasks/comments/{comment}', [\App\Http\Controllers\MainTaskCommentController::class, 'destroy'])->name('main-task.comments.destroy');
    Route::resource('subtasks', SubTaskController::class)->only(['store', 'update', 'destroy'])->names([
        'store' => 'subtask.store',
        'update' => 'subtask.update',
        'destroy' => 'subtask.destroy',
    ]);
    Route::patch('subtasks/{subtask}/toggle-status', [SubTaskController::class, 'toggleStatus'])->name('subtask.toggle-status');
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
    Route::get('sync', [\App\Http\Controllers\SyncController::class, 'getPulse'])->name('dashboard.sync');
    Route::get('reports/data', [\App\Http\Controllers\ReportController::class, 'getActivityData'])->name('dashboard.reports.data');
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('dashboard.notifications.mark-read');

    // Admin User Management
    Route::resource('users', \App\Http\Controllers\AdminUserController::class)->except(['create', 'edit', 'show'])->names([
        'index' => 'admin.users.index',
        'store' => 'admin.users.store',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\AdminUserController::class, 'resetPassword'])->name('admin.users.reset-password');

    // Developer Task Management
    Route::get('developer-tasks', [\App\Http\Controllers\DeveloperTaskController::class, 'index'])->name('developer-tasks.index');
    Route::post('developer-tasks', [\App\Http\Controllers\DeveloperTaskController::class, 'store'])->name('developer-tasks.store');
    Route::put('developer-tasks/{developer_task}', [\App\Http\Controllers\DeveloperTaskController::class, 'update'])->name('developer-tasks.update');
    Route::patch('developer-tasks/{developer_task}', [\App\Http\Controllers\DeveloperTaskController::class, 'updateStatus'])->name('developer-tasks.update-status');
    Route::post('developer-tasks/{developer_task}/comments', [\App\Http\Controllers\DeveloperTaskCommentController::class, 'store'])->name('developer-tasks.comments.store');
    Route::delete('developer-tasks/{developer_task}', [\App\Http\Controllers\DeveloperTaskController::class, 'destroy'])->name('developer-tasks.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/storage/{path}', function ($path) {
    $path = str_replace('..', '', $path);
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) abort(404);
    return response()->file($fullPath);
})->where('path', '.*');

require __DIR__.'/auth.php';
