<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sub_task_id' => 'required|exists:subtasks,id',
            'time' => 'required|numeric|min:0.01',
        ]);

        $timeLog = \App\Models\TimeLog::create([
            'sub_task_id' => $validated['sub_task_id'],
            'user_id' => auth()->id(),
            'time' => $validated['time'],
        ]);

        return response()->json([
            'message' => 'Time logged successfully',
            'time_log' => $timeLog->load('user'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timeLog = \App\Models\TimeLog::findOrFail($id);
        $timeLog->delete();

        return response()->json(['message' => 'Time log deleted successfully']);
    }
}
