<?php

namespace App\Http\Controllers;

use App\Models\DeveloperTask;
use App\Models\DeveloperTaskComment;
use App\Models\Notification;
use Illuminate\Http\Request;

class DeveloperTaskCommentController extends Controller
{
    /**
     * Store a new comment for a developer task.
     */
    public function store(Request $request, DeveloperTask $developer_task)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment = DeveloperTaskComment::create([
            'developer_task_id' => $developer_task->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        // Load the user who made the comment
        $comment->load('user');

        // Notification Logic
        $user = auth()->user();
        $targetUserId = null;
        $message = "";

        if ($user->isAdmin()) {
            // If admin comments, notify the developer
            $targetUserId = $developer_task->user_id;
            $message = "Admin commented on: " . $developer_task->title;
        } else {
            // If developer comments, notify the admin who assigned it
            $targetUserId = $developer_task->admin_id;
            $message = $user->name . " commented on: " . $developer_task->title;
        }

        if ($targetUserId && $targetUserId !== $user->id) {
            Notification::create([
                'user_id' => $targetUserId,
                'type' => 'developer_task_comment',
                'title' => 'New Task Comment',
                'message' => $message,
                'developer_task_id' => $developer_task->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => $comment
        ]);
    }
}
