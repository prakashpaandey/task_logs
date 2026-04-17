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
                'tasks' => DeveloperTask::with(['developers', 'admin'])->latest()->get()
            ]);
        }

        return response()->json([
            'success' => true,
            'tasks' => $user->assignedDeveloperTasks()->with(['admin', 'developers'])->latest()->get()
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
            'developer_ids' => 'required|array|min:1',
            'developer_ids.*' => 'exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date|after_or_equal:today',
            'description' => 'nullable|string',
        ]);

        // Clean developer_ids from duplicates and ensure they are NOT admins
        $devIds = array_unique($request->developer_ids);
        $developers = User::whereIn('id', $devIds)->where('role', '!=', 'super_admin')->get();
        
        if ($developers->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tasks must be assigned to at least one valid developer.'
            ], 422);
        }

        $task = DeveloperTask::create([
            'admin_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
            'status' => 'pending',
        ]);

        // Sync developers (Many-to-Many)
        $task->developers()->sync($developers->pluck('id'));

        // Create Notifications for ALL assigned Developers
        foreach ($developers as $developer) {
            Notification::create([
                'user_id' => $developer->id,
                'type' => 'developer_task_assigned',
                'developer_task_id' => $task->id,
                'message' => 'Super Admin assigned you to a new task: ' . $task->title,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Task assigned to ' . $developers->count() . ' developer(s) successfully.',
            'task' => $task->load('developers')
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
            'developer_ids' => 'required|array|min:1',
            'developer_ids.*' => 'exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date|after_or_equal:today',
            'description' => 'nullable|string',
        ]);

        $developerTask->update($request->only('title', 'priority', 'deadline', 'description'));

        // Sync updated developer list
        $devIds = array_unique($request->developer_ids);
        $developerTask->developers()->sync($devIds);

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully.',
            'task' => $developerTask->load('developers')
        ]);
    }

    /**
     * Update the status of the specified task.
     */
    public function updateStatus(Request $request, DeveloperTask $developerTask)
    {
        $user = auth()->user();

        // Security check: Admins OR assigned developers only
        $isAssigned = $developerTask->developers()->where('users.id', $user->id)->exists();
        if (!$user->isAdmin() && !$isAssigned) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You are not assigned to this task.'
            ], 403);
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
                'developer_task_id' => $developerTask->id,
                'message' => 'Task completed by ' . $user->name . ': ' . $developerTask->title,
            ]);

            // Notify OTHER assigned developers
            $otherDevelopers = $developerTask->developers()->where('users.id', '!=', $user->id)->get();
            foreach ($otherDevelopers as $otherDev) {
                Notification::create([
                    'user_id' => $otherDev->id,
                    'type' => 'developer_task_completed',
                    'developer_task_id' => $developerTask->id,
                    'message' => $user->name . ' marked the shared task as completed: ' . $developerTask->title,
                ]);
            }
        } else {
            $developerTask->update([
                'status' => $newStatus,
                'completed_at' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Task status updated.',
            'task' => $developerTask->load('developers')
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
