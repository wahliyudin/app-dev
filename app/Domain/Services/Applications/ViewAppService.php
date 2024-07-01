<?php

namespace App\Domain\Services\Applications;

use App\Enums\Request\Task\Status;
use App\Models\Request\RequestDeveloper;
use App\Models\Request\RequestFeatureTask;

class ViewAppService extends ApplicationService
{
    public function getTaskSummary($requestId)
    {
        $tasks = RequestFeatureTask::query()
            ->whereHas('feature', function ($query) use ($requestId) {
                $query->where('request_id', $requestId);
            })
            ->get();
        $now = now()->format('Y-m-d');
        $totalTasks = $tasks->count();
        $totalNotting = $tasks->filter(function ($task) use ($now) {
            return $task->status->isNotting() && $task->due_date >= $now;
        })->count();
        $totalInProgress = $tasks->filter(function ($task) use ($now) {
            return $task->status->isInProgress() && $task->due_date >= $now;
        })->count();
        $totalDone = $tasks->filter(function ($task) use ($now) {
            return $task->status->isDone();
        })->count();
        $totalOverdue = $tasks->filter(function ($task) use ($now) {
            return $task->due_date < $now && !$task->status->isDone();
        })->count();
        $totalNottingPercentage = $totalTasks === 0 ? 0 : round(($totalNotting / $totalTasks) * 100, 2);
        $totalInProgressPercentage = $totalTasks === 0 ? 0 : round(($totalInProgress / $totalTasks) * 100, 2);
        $totalDonePercentage = $totalTasks === 0 ? 0 : round(($totalDone / $totalTasks) * 100, 2);
        $totalOverduePercentage = $totalTasks === 0 ? 0 : round(($totalOverdue / $totalTasks) * 100, 2);

        return (object) [
            'total' => $totalTasks,
            'notting' => $totalNotting,
            'in_progress' => $totalInProgress,
            'done' => $totalDone,
            'overdue' => $totalOverdue,
            'data' => [$totalInProgressPercentage, $totalDonePercentage, $totalNottingPercentage, $totalOverduePercentage],
        ];
    }

    public function getTaskOvertime($year, $quarter)
    {
        list($startDate, $endDate) = quarterDateRange($quarter, $year);
        $tasks = RequestFeatureTask::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Menghitung total task yang masih dalam proses
        $incomplete = $tasks->filter(function ($task) {
            return in_array($task->status, [Status::NOTTING, Status::IN_PROGRESS]);
        })
            ->groupBy(function ($task) {
                return $task->created_at->format('n');
            })
            ->map(function ($task) {
                return $task->count();
            })
            ->pad(3, 0);

        // Menghitung total task yang sudah selesai
        $complete = $tasks->filter(function ($task) {
            return $task->status->isDone();
        })
            ->groupBy(function ($task) {
                return $task->created_at->format('n');
            })
            ->map(function ($task) {
                return $task->count();
            })
            ->pad(3, 0);

        return [
            'incomplete' => $incomplete->values(),
            'complete' => $complete->values(),
            'categories' => quarterDateRangeMonth($quarter, $year),
        ];
    }
    public function quarterOptions($year = null)
    {
        $year = $year ?? date('Y');
        return [
            [
                'quarter' => 1,
                'year' => $year,
                'label' => "$year Q1",
                'is_selected' => $year == date('Y') && date('n') <= 3,
            ],
            [
                'quarter' => 2,
                'year' => $year,
                'label' => "$year Q2",
                'is_selected' => $year == date('Y') && date('n') > 3 && date('n') <= 6,
            ],
            [
                'quarter' => 3,
                'year' => $year,
                'label' => "$year Q3",
                'is_selected' => $year == date('Y') && date('n') > 6 && date('n') <= 9,
            ],
            [
                'quarter' => 4,
                'year' => $year,
                'label' => "$year Q4",
                'is_selected' => $year == date('Y') && date('n') > 9,
            ],
        ];
    }

    public function getDevelopers($requestId)
    {
        return RequestDeveloper::query()
            ->where('request_id', $requestId)
            ->with(['developer' => function ($query) {
                $query->select('nik', 'nama_karyawan')
                    ->with('identity:nik,avatar');
            }, 'user' => function ($query) {
                $query->select('nik', 'name')
                    ->withCount(['tasks as total_task_open' => function ($query) {
                        $query->whereIn('status', [Status::NOTTING, Status::IN_PROGRESS]);
                    }, 'tasks as total_task_done' => function ($query) {
                        $query->whereIn('status', [Status::DONE]);
                    }]);
            }])
            ->get();
    }
}
