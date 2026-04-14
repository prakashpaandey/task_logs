<?php

namespace App\Http\Controllers;

use App\Models\SubTaskComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sub_task_id' => 'required|exists:subtasks,id',
            'comment' => 'required|string',
        ]);

        $user = auth()->user();
        $subtask = \App\Models\Subtask::findOrFail($request->sub_task_id);
        $clientId = $subtask->mainTask->client_id;

        if (!$user->isAdmin()) {
            if (!$user->clients()->where('clients.id', $clientId)->exists()) {
                abort(403, 'Unauthorized action. You are not assigned to this client.');
            }
        }

        $comment = SubTaskComment::create($request->all() + ['user_id' => $user->id]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Comment added successfully.', 'comment' => $comment->load('user')]);
        }
        return back()->with('success', 'Comment added successfully.');
    }

    public function update(Request $request, SubTaskComment $comment)
    {
        $this->authorizeUser($comment);
        $request->validate(['comment' => 'required|string']);
        $comment->update($request->only('comment'));

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Comment updated successfully.', 'comment' => $comment->load('user')]);
        }
        return back()->with('success', 'Comment updated successfully.');
    }

    public function destroy(SubTaskComment $comment)
    {
        $this->authorizeUser($comment);
        $comment->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
        }
        return back()->with('success', 'Comment deleted successfully.');
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
