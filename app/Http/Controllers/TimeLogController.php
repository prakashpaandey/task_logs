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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sub_task_id' => 'required|exists:subtasks,id',
            'time' => 'required|numeric|min:0.01',
        ]);

        $user = auth()->user();
        $subtask = \App\Models\Subtask::findOrFail($validated['sub_task_id']);
        $clientId = $subtask->mainTask->client_id;

        if (!$user->isAdmin()) {
            if (!$user->clients()->where('clients.id', $clientId)->exists()) {
                abort(403, 'Unauthorized action. You are not assigned to this client.');
            }
        }

        $timeLog = \App\Models\TimeLog::create([
            'sub_task_id' => $validated['sub_task_id'],
            'user_id' => $user->id,
            'time' => $validated['time'],
        ]);

        // Create notification for Super Admin if triggered by a developer
        if (!$user->isAdmin()) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'type' => 'time_log',
                'message' => "{$user->name} logged {$validated['time']} hours on Subtask: \"{$subtask->title}\"",
            ]);
        }

        // Sync total time in subtask table
        $timeLog->subtask->syncTimeLogged();

        return response()->json([
            'message' => 'Time logged successfully',
            'time_log' => $timeLog->load('user'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'time' => 'required|numeric|min:0.01',
        ]);

        $timeLog = \App\Models\TimeLog::findOrFail($id);
        $this->authorizeUser($timeLog);

        $timeLog->update([
            'time' => $validated['time'],
        ]);

        // Sync total time in subtask table
        $timeLog->subtask->syncTimeLogged();

        return response()->json([
            'message' => 'Time log updated successfully',
            'time_log' => $timeLog->load('user'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timeLog = \App\Models\TimeLog::findOrFail($id);
        $this->authorizeUser($timeLog);
        
        $subtask = $timeLog->subtask;
        $timeLog->delete();

        // Sync total time in subtask table
        $subtask->syncTimeLogged();

        return response()->json(['message' => 'Time log deleted successfully']);
    }

    protected function authorizeUser($model)
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return;
        }

        $clientId = $model->subtask->mainTask->client_id;
        if (!$user->clients()->where('clients.id', $clientId)->exists()) {
            abort(403, 'Unauthorized action. You are not assigned to this client.');
        }
    }
}
