<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SubTaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index()
    {
        return response()->json(SubTaskComment::where('user_id', auth()->id())->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_task_id' => 'required|exists:subtasks,id',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $comment = SubTaskComment::create([
            'sub_task_id' => $request->sub_task_id,
            'comment' => $request->comment,
            'user_id' => auth()->id() ?? $request->user_id,
        ]);

        return response()->json($comment, 201);
    }

    public function show(SubTaskComment $comment)
    {
        if ($comment->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($comment);
    }

    public function update(Request $request, SubTaskComment $comment)
    {
        if ($comment->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->update($request->only('comment'));
        return response()->json($comment);
    }

    public function destroy(SubTaskComment $comment)
    {
        if ($comment->user_id !== auth()->id() && auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
