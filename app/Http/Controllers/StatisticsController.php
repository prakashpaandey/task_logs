<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use App\Models\SubTaskComment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function getStatistics()
    {
        $userId = auth()->id();
        
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        $now = Carbon::now();
        $startOfToday = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        // Time Log Statistics
        $timeStats = [
            'today' => TimeLog::where('user_id', $userId)
                ->where('created_at', '>=', $startOfToday)
                ->sum('time'),
            'week' => TimeLog::where('user_id', $userId)
                ->where('created_at', '>=', $startOfWeek)
                ->sum('time'),
            'month' => TimeLog::where('user_id', $userId)
                ->where('created_at', '>=', $startOfMonth)
                ->sum('time'),
        ];

        // Comment Statistics
        $commentStats = [
            'today' => SubTaskComment::where('user_id', $userId)
                ->where('created_at', '>=', $startOfToday)
                ->count(),
            'week' => SubTaskComment::where('user_id', $userId)
                ->where('created_at', '>=', $startOfWeek)
                ->count(),
            'month' => SubTaskComment::where('user_id', $userId)
                ->where('created_at', '>=', $startOfMonth)
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'time_logs' => $timeStats,
            'comments' => $commentStats,
        ]);
    }
}
