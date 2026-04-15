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
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        $now = Carbon::now();
        $startOfToday = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        $isAdmin = $user->isAdmin();

        // 1. Time Log Totals
        $timeQuery = TimeLog::query();
        if (!$isAdmin) {
            $timeQuery->where('user_id', $user->id);
        }

        $timeStats = [
            'today' => (clone $timeQuery)->where('created_at', '>=', $startOfToday)->sum('time'),
            'week' => (clone $timeQuery)->where('created_at', '>=', $startOfWeek)->sum('time'),
            'month' => (clone $timeQuery)->where('created_at', '>=', $startOfMonth)->sum('time'),
        ];

        // 2. Comment Totals
        $commentQuery = SubTaskComment::query();
        if (!$isAdmin) {
            $commentQuery->where('user_id', $user->id);
        }

        $commentStats = [
            'today' => (clone $commentQuery)->where('created_at', '>=', $startOfToday)->count(),
            'week' => (clone $commentQuery)->where('created_at', '>=', $startOfWeek)->count(),
            'month' => (clone $commentQuery)->where('created_at', '>=', $startOfMonth)->count(),
        ];

        $breakdown = [];
        if ($isAdmin) {
            $breakdown = [
                'time' => [
                    'today' => $this->getUserTimeBreakdown($startOfToday),
                    'week' => $this->getUserTimeBreakdown($startOfWeek),
                    'month' => $this->getUserTimeBreakdown($startOfMonth),
                ],
                'comments' => [
                    'today' => $this->getUserCommentBreakdown($startOfToday),
                    'week' => $this->getUserCommentBreakdown($startOfWeek),
                    'month' => $this->getUserCommentBreakdown($startOfMonth),
                ]
            ];
        }

        return response()->json([
            'success' => true,
            'is_admin' => $isAdmin,
            'time_logs' => $timeStats,
            'comments' => $commentStats,
            'breakdown' => $breakdown
        ]);
    }

    protected function getUserTimeBreakdown($startDate)
    {
        return TimeLog::with('user')
            ->selectRaw('user_id, SUM(time) as total')
            ->where('created_at', '>=', $startDate)
            ->groupBy('user_id')
            ->get()
            ->map(function ($log) {
                return [
                    'user_name' => $log->user->name,
                    'user_email' => $log->user->email,
                    'initials' => strtoupper(substr($log->user->name, 0, 2)),
                    'value' => number_format($log->total, 1) . 'h'
                ];
            });
    }

    protected function getUserCommentBreakdown($startDate)
    {
        return SubTaskComment::with('user')
            ->selectRaw('user_id, COUNT(*) as total')
            ->where('created_at', '>=', $startDate)
            ->groupBy('user_id')
            ->get()
            ->map(function ($log) {
                return [
                    'user_name' => $log->user->name,
                    'user_email' => $log->user->email,
                    'initials' => strtoupper(substr($log->user->name, 0, 2)),
                    'value' => $log->total . ' comments'
                ];
            });
    }
}
