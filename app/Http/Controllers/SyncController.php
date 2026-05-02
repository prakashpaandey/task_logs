<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Http\Controllers\StatisticsController;

class SyncController extends Controller
{
    /**
     * Get the current global state for the dashboard pulse.
     */
    public function getPulse(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        // 1. Fetch Clients (Same logic as TaskController)
        $query = Client::with([
            'user', 
            'users', 
            'mainTasks' => function($q) use ($user) {
                if (!$user->isAdmin()) {
                    $q->where(function($inner) use ($user) {
                        $inner->where('user_id', $user->id)
                              ->orWhereHas('assignedUsers', function($sq) use ($user) {
                                  $sq->where('users.id', $user->id);
                              });
                    });
                }
                $q->with(['user', 'category', 'assignedUsers', 'subtasks.user', 'subtasks.comments.user', 'subtasks.timeLogs.user']);
            }
        ]);

        if (!$user->isAdmin()) {
            $query->where(function($q) use ($user) {
                $q->whereHas('users', function($inner) use ($user) {
                    $inner->where('users.id', $user->id);
                })->orWhereHas('mainTasks.assignedUsers', function($inner) use ($user) {
                    $inner->where('users.id', $user->id);
                });
            });
        }
        $clients = $query->get();

        // 2. Fetch Statistics (Reusing StatisticsController logic)
        $statsController = new StatisticsController();
        $statsResponse = $statsController->getStatistics();
        $statsData = $statsResponse->getData();

        // 3. Fetch Notifications for the Current User (Admin or Developer)
        $notifications = \App\Models\Notification::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(20)
            ->get();

        $users = [];
        if ($user->isAdmin()) {
            $users = User::all();
        }

        // 4. Fetch Developer Tasks
        $developerTasks = [];
        if ($user->isAdmin()) {
            $developerTasks = \App\Models\DeveloperTask::with(['developers', 'admin', 'comments.user'])->latest()->get();
        } else {
            $developerTasks = $user->assignedDeveloperTasks()->with(['admin', 'developers', 'comments.user'])->latest()->get();
        }

        return response()->json([
            'success' => true,
            'clients' => $clients,
            'statistics' => $statsData,
            'users' => $users,
            'notifications' => $notifications,
            'developer_tasks' => $developerTasks,
            'server_time' => now()->toIso8601String()
        ]);
    }
}
