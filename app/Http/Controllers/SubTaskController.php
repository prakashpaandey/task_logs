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
            if (!$user->clients()->where('clients.id', $mainTask->client_id)->exists()) {
                abort(403, 'Unauthorized action. You are not assigned to this client.');
            }
        }

        $subtask = Subtask::create($request->all() + ['user_id' => $user->id]);

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
        ]);
        $subtask->update($request->only('title', 'description', 'work_date'));

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Subtask updated successfully.', 'subtask' => $subtask->load('user')]);
        }
        return back()->with('success', 'Subtask updated successfully.');
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

        // 1. Enforce Ownership: Non-admins can only edit/delete their own subtasks
        if ($model->user_id !== $user->id) {
            abort(403, 'Unauthorized action. You can only edit or delete subtasks you created.');
        }

        // 2. Client Assignment Check (Safety Layer via Main Task)
        $mainTask = $model->mainTask;
        if (!$user->clients()->where('clients.id', $mainTask->client_id)->exists()) {
            abort(403, 'Unauthorized action. You are not assigned to this client.');
        }
    }
}
