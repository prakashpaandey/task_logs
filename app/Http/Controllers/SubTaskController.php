<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Http\Request;

class SubTaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'main_task_id' => 'required|exists:main_tasks,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'work_date' => 'required|date',
        ]);

        $user = auth()->user();
        $mainTask = \App\Models\MainTask::findOrFail($request->main_task_id);

        if (!$user->isAdmin()) {
            $isAssignedToClient = $user->clients()->where('clients.id', $mainTask->client_id)->exists();
            $isAssignedToMainTask = $mainTask->assignedUsers()->where('users.id', $user->id)->exists();
            
            if (!$isAssignedToClient && !$isAssignedToMainTask) {
                abort(403, 'Unauthorized action. You are not assigned to this client or task.');
            }
        }

        $subtask = Subtask::create($request->all() + ['user_id' => $user->id]);

        // Create notification for Super Admins if triggered by a developer
        if (!$user->isAdmin()) {
            $admins = \App\Models\User::where('role', 'super_admin')->get();
            foreach ($admins as $admin) {
                \App\Models\Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'subtask',
                    'client_id' => $mainTask->client_id,
                    'main_task_id' => $mainTask->id,
                    'sub_task_id' => $subtask->id,
                    'message' => "{$user->name} added a Subtask: \"{$subtask->title}\" for \"{$mainTask->title}\"",
                ]);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Subtask created successfully.', 'subtask' => $subtask->load('user')]);
        }
        return back()->with('success', 'Subtask created successfully.');
    }

    public function update(Request $request, Subtask $subtask)
    {
        $this->authorizeUser($subtask);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'work_date' => 'required|date',
            'status' => 'nullable|string|in:pending,completed',
        ]);
        $subtask->update($request->only('title', 'description', 'work_date', 'status'));

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Subtask updated successfully.', 'subtask' => $subtask->load('user')]);
        }
        return back()->with('success', 'Subtask updated successfully.');
    }

    public function toggleStatus(Subtask $subtask)
    {
        $this->authorizeUser($subtask);
        $subtask->status = $subtask->status === 'completed' ? 'pending' : 'completed';
        $subtask->save();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Subtask status updated.', 
                'subtask' => $subtask->load('user')
            ]);
        }
        return back()->with('success', 'Subtask status updated.');
    }

    public function destroy(Subtask $subtask)
    {
        $this->authorizeUser($subtask);
        $subtask->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Subtask deleted successfully.']);
        }
        return back()->with('success', 'Subtask deleted successfully.');
    }

    protected function authorizeUser($model)
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return;
        }

        // 1. Client/Task Assignment Check: Must be assigned to even see/touch the task
        $mainTask = $model->mainTask;
        $isAssignedToClient = $user->clients()->where('clients.id', $mainTask->client_id)->exists();
        $isAssignedToMainTask = $mainTask->assignedUsers()->where('users.id', $user->id)->exists();
        
        if (!$isAssignedToClient && !$isAssignedToMainTask) {
            abort(403, 'Unauthorized action. You are not assigned to this client or task.');
        }

        // 2. Action-Specific Authorization
        $routeName = request()->route()->getName();
        
        // If toggling status, being assigned is sufficient (per user request)
        if ($routeName === 'subtask.toggle-status') {
            return;
        }

        // For editing or deleting, you must be the creator (ownership)
        if ($model->user_id !== $user->id) {
            abort(403, 'Unauthorized action. You can only edit or delete subtasks you created.');
        }
    }
}
