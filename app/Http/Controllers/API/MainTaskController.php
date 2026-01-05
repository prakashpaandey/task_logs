<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MainTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainTaskController extends Controller
{
    public function index()
    {
        return response()->json(MainTask::where('user_id', auth()->id())->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mainTask = MainTask::create([
            'client_id' => $request->client_id,
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id() ?? $request->user_id,
        ]);

        return response()->json($mainTask, 201);
    }

    public function show(MainTask $mainTask)
    {
        if ($mainTask->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($mainTask);
    }

    public function update(Request $request, MainTask $mainTask)
    {
        if ($mainTask->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $mainTask->update($request->only('title', 'description'));
        return response()->json($mainTask);
    }

    public function destroy(MainTask $mainTask)
    {
        if ($mainTask->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $mainTask->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
