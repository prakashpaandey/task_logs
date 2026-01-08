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
        $mainTask = MainTask::create($request->all() + ['user_id' => auth()->id()]);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Main Task created successfully.', 'mainTask' => $mainTask->load('user')]);
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
            return response()->json(['success' => true, 'message' => 'Main Task updated successfully.', 'mainTask' => $main_task->load('user')]);
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
        // All users are admins and can manage all data
        // if ($model->user_id !== auth()->id()) {
        //     abort(403);
        // }
    }
}
