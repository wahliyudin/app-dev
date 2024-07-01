<?php

namespace App\Domain\Services\Applications;

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
        $totalNottingPercentage = round(($totalNotting / $totalTasks) * 100, 2);
        $totalInProgressPercentage = round(($totalInProgress / $totalTasks) * 100, 2);
        $totalDonePercentage = round(($totalDone / $totalTasks) * 100, 2);
        $totalOverduePercentage = round(($totalOverdue / $totalTasks) * 100, 2);

        return (object) [
            'total' => $totalTasks,
            'notting' => $totalNotting,
            'in_progress' => $totalInProgress,
            'done' => $totalDone,
            'overdue' => $totalOverdue,
            'data' => [$totalInProgressPercentage, $totalDonePercentage, $totalNottingPercentage, $totalOverduePercentage],
        ];
    }
}
