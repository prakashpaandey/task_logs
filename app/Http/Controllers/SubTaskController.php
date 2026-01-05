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
            'time_logged' => 'required|string',
        ]);
        $subtask = Subtask::create($request->all() + ['user_id' => auth()->id()]);

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
            'time_logged' => 'required|string',
        ]);
        $subtask->update($request->only('title', 'description', 'work_date', 'time_logged'));

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
        // All users are admins and can manage all data
        // if ($model->user_id !== auth()->id()) {
        //     abort(403);
        // }
    }
}
