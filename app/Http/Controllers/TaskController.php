<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\MainTask;
use App\Models\Subtask;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Client::with(['user', 'users', 'mainTasks.user', 'mainTasks.category', 'mainTasks.subtasks.user', 'mainTasks.subtasks.comments.user', 'mainTasks.subtasks.timeLogs.user']);
        
        if (!$user->isAdmin()) {
            // Developers only see assigned clients
            $query->whereHas('users', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        $clients = $query->get();
            
        $categories = \App\Models\Category::all();

        $selectedClient = null;
        if ($request->has('client_id')) {
            $selectedClient = $clients->firstWhere('id', $request->client_id);
        }
        
        $users = [];
        if ($user->isAdmin()) {
            $users = \App\Models\User::all();
        }

        // Fetch Notifications for initial load
        $notifications = \App\Models\Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->latest()
            ->limit(20)
            ->get();

        // Fetch Developer Tasks for initial load
        $developerTasks = [];
        if ($user->isAdmin()) {
            $developerTasks = \App\Models\DeveloperTask::with(['developer', 'admin', 'comments.user'])->latest()->get();
        } else {
            $developerTasks = \App\Models\DeveloperTask::where('user_id', $user->id)->with(['developer', 'admin', 'comments.user'])->latest()->get();
        }
        
        return view('dashboard.index', compact('clients', 'categories', 'selectedClient', 'users', 'notifications', 'developerTasks'));
    }
}
