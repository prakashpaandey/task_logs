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

        // Notification Logic: Notify ALL participants except the commenter
        $user = auth()->user();
        $message = $user->isAdmin() ? "Admin commented on: " . $developer_task->title : $user->name . " commented on: " . $developer_task->title;

        // 1. Always notify the Admin if a developer comments
        if (!$user->isAdmin()) {
            Notification::create([
                'user_id' => $developer_task->admin_id,
                'type' => 'developer_task_comment',
                'message' => $message,
                'developer_task_id' => $developer_task->id,
            ]);
        }

        // 2. Notify all OTHER assigned developers
        $developersToNotify = $developer_task->developers()->where('users.id', '!=', $user->id)->get();
        foreach ($developersToNotify as $dev) {
            Notification::create([
                'user_id' => $dev->id,
                'type' => 'developer_task_comment',
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
