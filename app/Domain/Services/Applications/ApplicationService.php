<?php

namespace App\Domain\Services\Applications;

use App\Enums\Request\Application\Status as ApplicationStatus;
use App\Enums\Request\Task\Status;
use App\Models\Request\RequestApplication;
use App\Models\Request\RequestFeatureTask;

class ApplicationService
{
    public function findOrFail($id)
    {
        return RequestApplication::query()
            ->with(['request' => function ($query) {
                $query->select(['id', 'code', 'application_id'])
                    ->with(['developers' => function ($query) {
                        $query->with(['developer' => function ($query) {
                            $query->select('nik', 'nama_karyawan')
                                ->with('identity:nik,avatar');
                        }]);
                    }]);
            }, 'features' => function ($query) {
                $query->withCount(['tasks as total_open' => function ($query) {
                    $query->where('status', Status::NOTTING);
                }, 'tasks as total_progress' => function ($query) {
                    $query->where('status', Status::IN_PROGRESS);
                }, 'tasks as total_done' => function ($query) {
                    $query->where('status', Status::DONE);
                }]);
            }])
            ->findOrFail($id);
    }

    public function getTaskSummary($appId = null)
    {
        $tasks = RequestFeatureTask::query()
            ->when($appId, function ($query) use ($appId) {
                $query->whereHas('feature', function ($query) use ($appId) {
                    $query->where('application_id', $appId);
                });
            })
            ->when(hasRole('developer'), function ($query) {
                $query->whereHas('developers', function ($query) {
                    $query->where('nik', authUser()?->nik);
                });
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

    public function getAll()
    {
        return RequestApplication::query()->get();
    }

    public function updateCurrentOverdue()
    {
        return RequestApplication::query()
            ->where('due_date', '<', now()->format('Y-m-d'))
            ->where('status', '!=', ApplicationStatus::OVERDUE)
            ->update(['status', ApplicationStatus::OVERDUE]);
    }
}
