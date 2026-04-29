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
        
        $query = Client::with(['user', 'users', 'mainTasks.user', 'mainTasks.category', 'mainTasks.assignedUsers', 'mainTasks.subtasks.user', 'mainTasks.subtasks.comments.user', 'mainTasks.subtasks.timeLogs.user']);
        
        if (!$user->isAdmin()) {
            // Developers see assigned clients OR clients with main tasks assigned to them
            $query->where(function($q) use ($user) {
                $q->whereHas('users', function($inner) use ($user) {
                    $inner->where('users.id', $user->id);
                })->orWhereHas('mainTasks.assignedUsers', function($inner) use ($user) {
                    $inner->where('users.id', $user->id);
                });
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
            ->latest()
            ->limit(20)
            ->get();

        // Fetch Developer Tasks for initial load
        $developerTasks = [];
        if ($user->isAdmin()) {
            $developerTasks = \App\Models\DeveloperTask::with(['developers', 'admin', 'comments.user'])->latest()->get();
        } else {
            $developerTasks = $user->assignedDeveloperTasks()->with(['developers', 'admin', 'comments.user'])->latest()->get();
        }
        
        return view('dashboard.index', compact('clients', 'categories', 'selectedClient', 'users', 'notifications', 'developerTasks'));
    }
}
