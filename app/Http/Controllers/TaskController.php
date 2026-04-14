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
        
        return view('dashboard.index', compact('clients', 'categories', 'selectedClient', 'users'));
    }
}
