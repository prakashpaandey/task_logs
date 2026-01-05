<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subtask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubTaskController extends Controller
{
    public function index()
    {
        return response()->json(Subtask::where('user_id', auth()->id())->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_task_id' => 'required|exists:main_tasks,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'work_date' => 'required|date',
            'time_logged' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $subtask = Subtask::create([
            'main_task_id' => $request->main_task_id,
            'title' => $request->title,
            'description' => $request->description,
            'work_date' => $request->work_date,
            'time_logged' => $request->time_logged,
            'user_id' => auth()->id() ?? $request->user_id,
        ]);

        return response()->json($subtask, 201);
    }

    public function show(Subtask $subtask)
    {
        if ($subtask->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($subtask);
    }

    public function update(Request $request, Subtask $subtask)
    {
        if ($subtask->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $subtask->update($request->only('title', 'description', 'work_date', 'time_logged'));
        return response()->json($subtask);
    }

    public function destroy(Subtask $subtask)
    {
        if ($subtask->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $subtask->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
