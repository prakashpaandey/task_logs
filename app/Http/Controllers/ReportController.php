<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\MainTask;
use App\Models\Subtask;
use App\Models\TimeLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function getActivityData(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        $type = $request->query('type', 'user'); // 'user' or 'client'
        $period = $request->query('period', 'week'); // 'today', 'week', 'month', 'custom'
        $targetId = $request->query('target_id'); // user_id or client_id
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Enforcement: Developers can only see their own 'user' report
        if (!$isAdmin) {
            $type = 'user';
            $targetId = $user->id;
        }

        // 1. Determine Date Range
        $range = $this->getDateRange($period, $startDate, $endDate);
        
        // 2. Build Query
        $query = TimeLog::with(['user', 'subtask.mainTask.client'])
            ->whereBetween('created_at', [$range['start'], $range['end']]);

        if ($type === 'user' && $targetId) {
            $query->where('user_id', $targetId);
        } elseif ($type === 'client' && $targetId) {
            $query->whereHas('subtask.mainTask', function($q) use ($targetId) {
                $q->where('client_id', $targetId);
            });
        }

        // 3. Get Paginated Results
        $logs = $query->latest()->paginate(50);

        // 4. Calculate Summaries
        $summary = $this->calculateSummary($type, $targetId, $range);

        return response()->json([
            'success' => true,
            'data' => $logs->items(),
            'pagination' => [
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'total' => $logs->total(),
                'per_page' => $logs->perPage(),
            ],
            'summary' => $summary,
            'filters' => [
                'type' => $type,
                'period' => $period,
                'target_id' => $targetId,
                'start_date' => $range['start']->toDateString(),
                'end_date' => $range['end']->toDateString()
            ]
        ]);
    }

    private function getDateRange($period, $start = null, $end = null)
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::tomorrow()->subSecond();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'custom':
                if ($start && $end) {
                    $startDate = Carbon::parse($start)->startOfDay();
                    $endDate = Carbon::parse($end)->endOfDay();
                } else {
                    $startDate = Carbon::now()->subDays(30)->startOfDay();
                }
                break;
            default: // Default to week
                $startDate = Carbon::now()->startOfWeek();
        }

        return ['start' => $startDate, 'end' => $endDate];
    }

    private function calculateSummary($type, $targetId, $range)
    {
        $timeQuery = TimeLog::whereBetween('created_at', [$range['start'], $range['end']]);
        
        if ($type === 'user' && $targetId) {
            $timeQuery->where('user_id', $targetId);
        } elseif ($type === 'client' && $targetId) {
            $timeQuery->whereHas('subtask.mainTask', function($q) use ($targetId) {
                $q->where('client_id', $targetId);
            });
        }

        $totalHours = (float) $timeQuery->sum('time');
        $taskCount = $timeQuery->distinct('sub_task_id')->count('sub_task_id');
        
        $developerCount = 0;
        $developerBreakdown = [];
        if ($type === 'client' && $targetId) {
            $developerCount = $timeQuery->distinct('user_id')->count('user_id');
            
            $developerBreakdown = (clone $timeQuery)
                ->with('user')
                ->selectRaw('user_id, SUM(time) as total')
                ->groupBy('user_id')
                ->get()
                ->map(function($item) {
                    return [
                        'user_name' => $item->user->name,
                        'hours' => number_format($item->total, 1)
                    ];
                });
        }

        return [
            'total_hours' => number_format($totalHours, 1),
            'task_count' => $taskCount,
            'developer_count' => $developerCount,
            'developer_breakdown' => $developerBreakdown
        ];
    }
}
