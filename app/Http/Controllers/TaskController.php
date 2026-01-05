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
        $clients = Client::with(['user', 'mainTasks.user', 'mainTasks.subtasks.user', 'mainTasks.subtasks.comments.user'])
            ->get();
            
        $selectedClient = null;
        if ($request->has('client_id')) {
            $selectedClient = $clients->firstWhere('id', $request->client_id);
        }
        
        return view('dashboard.index', compact('clients', 'selectedClient'));
    }
}
