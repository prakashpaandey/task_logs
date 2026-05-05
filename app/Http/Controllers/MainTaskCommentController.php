<?php

namespace App\Http\Controllers;

use App\Models\MainTask;
use App\Models\MainTaskComment;
use Illuminate\Http\Request;

class MainTaskCommentController extends Controller
{
    public function store(Request $request, MainTask $main_task)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $user = auth()->user();
        
        // Authorization: Only assigned users or super admins
        $isAssigned = $main_task->assignedUsers()->where('users.id', $user->id)->exists();
        $isClientAssigned = $user->clients()->where('clients.id', $main_task->client_id)->exists();
        
        if (!$user->isAdmin() && !$isAssigned && !$isClientAssigned) {
            abort(403, 'Unauthorized action. You are not assigned to this task.');
        }

        $comment = $main_task->comments()->create([
            'user_id' => $user->id,
            'comment' => $request->comment,
        ]);

        // Create notifications for other assigned users and admins
        $notifiableUsers = $main_task->assignedUsers()->where('users.id', '!=', $user->id)->get();
        if ($user->isAdmin()) {
            // If admin posts, notify all assigned users
        } else {
            // If developer posts, notify admins
            $admins = \App\Models\User::where('role', 'super_admin')->get();
            $notifiableUsers = $notifiableUsers->concat($admins)->unique('id');
        }

        foreach ($notifiableUsers as $nUser) {
            if ($nUser->id === $user->id) continue;
            \App\Models\Notification::create([
                'user_id' => $nUser->id,
                'type' => 'main_task_comment',
                'client_id' => $main_task->client_id,
                'main_task_id' => $main_task->id,
                'message' => "{$user->name} posted a message in \"{$main_task->title}\"",
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'comment' => $comment->load('user')
        ]);
    }
    public function update(Request $request, MainTaskComment $comment)
    {
        $this->authorizeComment($comment);

        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment->update([
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message updated successfully.',
            'comment' => $comment->load('user')
        ]);
    }

    public function destroy(MainTaskComment $comment)
    {
        $this->authorizeComment($comment);

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully.'
        ]);
    }

    private function authorizeComment(MainTaskComment $comment)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $comment->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
