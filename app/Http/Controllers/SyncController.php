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
            'mainTasks.user', 
            'mainTasks.category', 
            'mainTasks.subtasks.user', 
            'mainTasks.subtasks.comments.user', 
            'mainTasks.subtasks.timeLogs.user'
        ]);

        if (!$user->isAdmin()) {
            $query->whereHas('users', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }
        $clients = $query->get();

        // 2. Fetch Statistics (Reusing StatisticsController logic)
        $statsController = new StatisticsController();
        $statsResponse = $statsController->getStatistics();
        $statsData = $statsResponse->getData();

        // 3. Optional: Users list & Notifications for Admins
        $users = [];
        $notifications = [];
        
        if ($user->isAdmin()) {
            $users = User::all();
            $notifications = \App\Models\Notification::with('user')
                ->whereNull('read_at')
                ->latest()
                ->limit(20)
                ->get();
        }

        return response()->json([
            'success' => true,
            'clients' => $clients,
            'statistics' => $statsData,
            'users' => $users,
            'notifications' => $notifications,
            'server_time' => now()->toIso8601String()
        ]);
    }
}
