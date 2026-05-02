<?php

namespace App\Http\Controllers;

use App\Models\SubTaskComment;
use App\Models\SubTaskCommentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sub_task_id' => 'required|exists:subtasks,id',
            'comment' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = auth()->user();
        $subtask = \App\Models\Subtask::findOrFail($request->sub_task_id);
        $clientId = $subtask->mainTask->client_id;

        if (!$user->isAdmin()) {
            if (!$user->clients()->where('clients.id', $clientId)->exists()) {
                abort(403, 'Unauthorized action. You are not assigned to this client.');
            }
        }

        $comment = SubTaskComment::create([
            'sub_task_id' => $request->sub_task_id,
            'comment' => $request->comment,
            'user_id' => $user->id
        ]);

        // Handle Image Uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('comment_images', 'public');
                SubTaskCommentImage::create([
                    'sub_task_comment_id' => $comment->id,
                    'image_path' => $path
                ]);
            }
        }

        // Create notification for Super Admins if triggered by a developer
        if (!$user->isAdmin()) {
            $admins = \App\Models\User::where('role', 'super_admin')->get();
            foreach ($admins as $admin) {
                \App\Models\Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'comment',
                    'client_id' => $clientId,
                    'main_task_id' => $subtask->main_task_id,
                    'sub_task_id' => $subtask->id,
                    'message' => "{$user->name} posted a comment on Subtask: \"{$subtask->title}\"",
                ]);
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Comment added successfully.', 
                'comment' => $comment->load(['user', 'images'])
            ]);
        }
        return back()->with('success', 'Comment added successfully.');
    }

    public function update(Request $request, SubTaskComment $comment)
    {
        $this->authorizeUser($comment);
        $request->validate(['comment' => 'required|string']);
        $comment->update($request->only('comment'));

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Comment updated successfully.', 'comment' => $comment->load(['user', 'images'])]);
        }
        return back()->with('success', 'Comment updated successfully.');
    }

    public function destroy(SubTaskComment $comment)
    {
        $this->authorizeUser($comment);
        
        // Delete associated images from storage
        foreach ($comment->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
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
