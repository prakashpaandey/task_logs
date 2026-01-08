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
        $comment = SubTaskComment::create($request->all() + ['user_id' => auth()->id()]);

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
        if ($model->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
