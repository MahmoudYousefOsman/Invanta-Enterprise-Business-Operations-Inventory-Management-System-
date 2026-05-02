<?php

namespace App\Http\Services;

use App\Models\Task;
use App\Models\Engineer;
use App\Models\Client;

class TaskAssignmentService
{
    /**
     * الحصول على جميع مهام المهندس
     */
    public function getEngineerTasks(Engineer $engineer, $status = null)
    {
        $query = Task::where('engineer_id', $engineer->id);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'DESC')->get();
    }

    /**
     * عدد المهام الجديدة للمهندس
     */
    public function getNewTasksCount(Engineer $engineer)
    {
        return Task::where('engineer_id', $engineer->id)
            ->where('status', 'new')
            ->count();
    }

    /**
     * المهام المكتملة للمهندس
     */
    public function getCompletedTasks(Engineer $engineer)
    {
        return Task::where('engineer_id', $engineer->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * المهام الملغاة للمهندس
     */
    public function getCancelledTasks(Engineer $engineer)
    {
        return Task::where('engineer_id', $engineer->id)
            ->where('status', 'cancelled')
            ->get();
    }

    /**
     * المهام المعلقة للمهندس
     */
    public function getPendingTasks(Engineer $engineer)
    {
        return Task::where('engineer_id', $engineer->id)
            ->where('status', 'new')
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    /**
     * إحصائيات المهندس
     */
    public function getEngineerStats(Engineer $engineer)
    {
        $allTasks = Task::where('engineer_id', $engineer->id)->get();

        return [
            'total_tasks' => $allTasks->count(),
            'new_tasks' => $allTasks->where('status', 'new')->count(),
            'completed_tasks' => $allTasks->where('status', 'completed')->count(),
            'cancelled_tasks' => $allTasks->where('status', 'cancelled')->count(),
            'total_cost' => $allTasks->sum('cost'),
            'total_payed' => $allTasks->sum('payed')
        ];
    }

    /**
     * متوسط عدد المهام اليومية للمهندس
     */
    public function getAverageDailyTasks(Engineer $engineer, $days = 30)
    {
        $fromDate = now()->subDays($days);
        $tasks = Task::where('engineer_id', $engineer->id)
            ->whereDate('created_at', '>=', $fromDate)
            ->count();

        return $days > 0 ? $tasks / $days : 0;
    }

    /**
     * تقييم أداء المهندس
     */
    public function getEngineerPerformance(Engineer $engineer)
    {
        $stats = $this->getEngineerStats($engineer);

        $completionRate = $stats['total_tasks'] > 0
            ? ($stats['completed_tasks'] / $stats['total_tasks'] * 100)
            : 0;

        return [
            'stats' => $stats,
            'completion_rate' => round($completionRate, 2),
            'rating' => $completionRate >= 80 ? 'ممتاز' : ($completionRate >= 60 ? 'جيد' : 'يحتاج تحسين')
        ];
    }
}
