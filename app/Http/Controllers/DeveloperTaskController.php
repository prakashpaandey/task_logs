<?php

namespace App\Http\Controllers;

use App\Models\DeveloperTask;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DeveloperTaskController extends Controller
{
    /**
     * Display a listing of developer tasks.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return response()->json([
                'success' => true,
                'tasks' => DeveloperTask::with(['developer', 'admin'])->latest()->get()
            ]);
        }

        return response()->json([
            'success' => true,
            'tasks' => DeveloperTask::where('user_id', $user->id)->with(['admin'])->latest()->get()
        ]);
    }

    /**
     * Store a newly created developer task in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date|after_or_equal:today',
            'description' => 'nullable|string',
        ]);

        // Secondary check to ensure user_id is a developer
        $developer = User::find($request->user_id);
        if ($developer->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Tasks can only be assigned to developers.'
            ], 422);
        }

        $task = DeveloperTask::create([
            'user_id' => $request->user_id,
            'admin_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
            'status' => 'pending',
        ]);

        // Create Notification for the Developer
        Notification::create([
            'user_id' => $request->user_id,
            'type' => 'developer_task_assigned',
            'message' => 'Super Admin assigned a new task: ' . $task->title,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task assigned successfully.',
            'task' => $task->load('developer')
        ]);
    }

    /**
     * Update the specified developer task in storage.
     */
    public function update(Request $request, DeveloperTask $developerTask)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        if ($developerTask->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending tasks can be edited.'
            ], 422);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date|after_or_equal:today',
            'description' => 'nullable|string',
        ]);

        $developerTask->update($request->only('title', 'priority', 'deadline', 'description'));

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully.',
            'task' => $developerTask->load('developer')
        ]);
    }

    /**
     * Update the status of the specified task.
     */
    public function updateStatus(Request $request, DeveloperTask $developerTask)
    {
        $user = auth()->user();

        // Security check
        if (!$user->isAdmin() && $developerTask->user_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        $newStatus = $request->status;
        if (!in_array($newStatus, ['pending', 'completed'])) {
            return response()->json(['success' => false, 'message' => 'Invalid status.'], 422);
        }

        if ($newStatus === 'completed' && $developerTask->status !== 'completed') {
            $developerTask->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);

            // Notify Admin
            Notification::create([
                'user_id' => $developerTask->admin_id,
                'type' => 'developer_task_completed',
                'message' => 'Developer ' . $user->name . ' completed task: ' . $developerTask->title,
            ]);
        } else {
            $developerTask->update([
                'status' => $newStatus,
                'completed_at' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Task status updated.',
            'task' => $developerTask
        ]);
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(DeveloperTask $developerTask)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $developerTask->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully.'
        ]);
    }
}
