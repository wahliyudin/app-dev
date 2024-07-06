<?php

namespace App\Domain\Services\Applications;

use App\Enums\Request\Task\Status;
use App\Models\Request\RequestDeveloper;
use App\Models\Request\RequestFeatureTask;

class ViewAppService extends ApplicationService
{
    public function getTaskOvertime($appId, $year, $quarter)
    {
        list($startDate, $endDate) = quarterDateRange($quarter, $year);
        $tasks = RequestFeatureTask::query()
            ->whereHas('feature', function ($query) use ($appId) {
                $query->where('application_id', $appId);
            })
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

    public function getDevelopers($requestId, $appId)
    {
        return RequestDeveloper::query()
            ->where('request_id', $requestId)
            ->with(['developer' => function ($query) {
                $query->select('nik', 'nama_karyawan')
                    ->with('identity:nik,avatar');
            }, 'user' => function ($query) use ($appId) {
                $query->select('nik', 'name')
                    ->withCount(['tasks as total_task_open' => function ($query) use ($appId) {
                        $query->whereHas('feature', function ($query) use ($appId) {
                            $query->where('application_id', $appId);
                        })->whereIn('status', [Status::NOTTING, Status::IN_PROGRESS]);
                    }, 'tasks as total_task_done' => function ($query) use ($appId) {
                        $query->whereHas('feature', function ($query) use ($appId) {
                            $query->where('application_id', $appId);
                        })->whereIn('status', [Status::DONE]);
                    }]);
            }])
            ->get();
    }
}
