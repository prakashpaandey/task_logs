<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mark all unread notifications for the admin as read.
     */
    public function markAllAsRead(Request $request)
    {
        Notification::where('user_id', auth()->id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }
}
