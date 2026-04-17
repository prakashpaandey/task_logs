<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use App\Models\SubTaskComment;
use App\Models\DeveloperTaskComment;
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

        // 2. Comment Totals (Merged Subtask & Developer Task Comments)
        $subTaskCommentQuery = SubTaskComment::query();
        $devTaskCommentQuery = DeveloperTaskComment::query();

        if (!$isAdmin) {
            $subTaskCommentQuery->where('user_id', $user->id);
            $devTaskCommentQuery->where('user_id', $user->id);
        }

        $commentStats = [
            'today' => (clone $subTaskCommentQuery)->where('created_at', '>=', $startOfToday)->count() + 
                       (clone $devTaskCommentQuery)->where('created_at', '>=', $startOfToday)->count(),
            'week' => (clone $subTaskCommentQuery)->where('created_at', '>=', $startOfWeek)->count() + 
                      (clone $devTaskCommentQuery)->where('created_at', '>=', $startOfWeek)->count(),
            'month' => (clone $subTaskCommentQuery)->where('created_at', '>=', $startOfMonth)->count() + 
                       (clone $devTaskCommentQuery)->where('created_at', '>=', $startOfMonth)->count(),
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

        // 3. Recent Activity (Latest logs)
        $recentActivity = TimeLog::with(['subtask.mainTask.client'])
            ->whereBetween('created_at', [$now->copy()->subDays(30), $now]);
        
        if (!$isAdmin) {
            $recentActivity->where('user_id', $user->id);
        }
        
        $recentActivity = $recentActivity->latest()->limit(10)->get();

        // 4. Recent Discussions (Task Comments)
        $recentComments = DeveloperTaskComment::with(['user', 'task'])
            ->latest()
            ->limit(5);
        
        if (!$isAdmin) {
            $recentComments->whereHas('task.developers', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }
        $recentComments = $recentComments->get();

        return response()->json([
            'success' => true,
            'is_admin' => $isAdmin,
            'time_logs' => $timeStats,
            'comments' => $commentStats,
            'breakdown' => $breakdown,
            'recent_activity' => $recentActivity,
            'recent_discussions' => $recentComments
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
        $subTaskComments = SubTaskComment::with('user')
            ->selectRaw('user_id, COUNT(*) as total')
            ->where('created_at', '>=', $startDate)
            ->groupBy('user_id')
            ->get();

        $devTaskComments = DeveloperTaskComment::with('user')
            ->selectRaw('user_id, COUNT(*) as total')
            ->where('created_at', '>=', $startDate)
            ->groupBy('user_id')
            ->get();

        $merged = [];
        // Process Subtasks
        foreach ($subTaskComments as $c) {
            $merged[$c->user_id] = [
                'name' => $c->user->name,
                'email' => $c->user->email,
                'total' => $c->total
            ];
        }

        // Process Dev tasks
        foreach ($devTaskComments as $c) {
            if (isset($merged[$c->user_id])) {
                $merged[$c->user_id]['total'] += $c->total;
            } else {
                $merged[$c->user_id] = [
                    'name' => $c->user->name,
                    'email' => $c->user->email,
                    'total' => $c->total
                ];
            }
        }

        return collect($merged)->map(function ($data) {
            return [
                'user_name' => $data['name'],
                'user_email' => $data['email'],
                'initials' => strtoupper(substr($data['name'], 0, 2)),
                'value' => $data['total'] . ' comments'
            ];
        })->values();
    }
}
