<?php

namespace App\Http\Controllers;

use App\Models\MainTask;
use Illuminate\Http\Request;

class MainTaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $user = auth()->user();
        if (!$user->isAdmin()) {
            if (!$user->clients()->where('clients.id', $request->client_id)->exists()) {
                abort(403, 'Unauthorized action. You are not assigned to this client.');
            }
        }

        $mainTask = MainTask::create($request->all() + ['user_id' => $user->id]);

        // Create notification for Super Admins if triggered by a developer
        if (!$user->isAdmin()) {
            $admins = \App\Models\User::where('role', 'super_admin')->get();
            foreach ($admins as $admin) {
                \App\Models\Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'main_task',
                    'client_id' => $request->client_id,
                    'main_task_id' => $mainTask->id,
                    'message' => "{$user->name} created a new Main Task: \"{$mainTask->title}\"",
                ]);
            }
        }
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Main Task created successfully.', 'mainTask' => $mainTask->load(['user', 'category'])]);
        }
        return back()->with('success', 'Main Task created successfully.');
    }

    public function update(Request $request, MainTask $main_task)
    {
        $this->authorizeUser($main_task);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        $main_task->update($request->only('title', 'description', 'category_id'));

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Main Task updated successfully.', 'mainTask' => $main_task->load(['user', 'category'])]);
        }
        return back()->with('success', 'Main Task updated successfully.');
    }

    public function destroy(MainTask $main_task)
    {
        $this->authorizeUser($main_task);
        $main_task->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Main Task deleted successfully.']);
        }
        return back()->with('success', 'Main Task deleted successfully.');
    }

    protected function authorizeUser($model)
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return;
        }

        // 1. Enforce Ownership: Non-admins can only edit/delete their own tasks
        if ($model->user_id !== $user->id) {
            abort(403, 'Unauthorized action. You can only edit or delete tasks you created.');
        }

        // 2. Client Assignment Check (Safety Layer)
        $clientId = $model->client_id ?? $model->mainTask->client_id;
        if (!$user->clients()->where('clients.id', $clientId)->exists()) {
            abort(403, 'Unauthorized action. You are not assigned to this client.');
        }
    }
}
