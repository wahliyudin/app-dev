<?php

namespace App\Domain\Services\Applications;

use App\Enums\Request\Application\Status;
use App\Enums\Request\Task\Status as TaskStatus;
use App\Models\Request\RequestApplication;

class MyAppService extends ApplicationService
{
    public function getApps($status = null)
    {
        return RequestApplication::query()
            ->with(['request' => function ($query) {
                $query->select(['id', 'code', 'application_id'])
                    ->with(['features' => function ($query) {
                        $query->withCount(['tasks as total_open' => function ($query) {
                            $query->where('status', TaskStatus::NOTTING);
                        }, 'tasks as total_progress' => function ($query) {
                            $query->where('status', TaskStatus::IN_PROGRESS);
                        }, 'tasks as total_done' => function ($query) {
                            $query->where('status', TaskStatus::DONE);
                        }]);
                    }, 'developers' => function ($query) {
                        $query->with(['developer' => function ($query) {
                            $query->select('nik', 'nama_karyawan')
                                ->with('identity:nik,avatar');
                        }]);
                    }]);
            }])
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->paginate(3);
    }

    public function getCurrentApp()
    {
        $apps = RequestApplication::query()
            ->get();
        $total = $apps->count();
        $pending = $apps->where('status', Status::PENDING)->count();
        $in_progress = $apps->where('status', Status::IN_PROGRESS)->count();
        $completed = $apps->where('status', Status::COMPLETED)->count();
        $yet_to_start = $apps->where('status', Status::YET_TO_START)->count();
        $percentages = [
            ($total > 0) ? $in_progress / $total * 100 : 0,
            ($total > 0) ? $completed / $total * 100 : 0,
            ($total > 0) ? $yet_to_start / $total * 100 : 0,
            ($total > 0) ? $pending / $total * 100 : 0,
        ];
        return (object) [
            'total' => $total,
            'pending' => $pending,
            'in_progress' => $in_progress,
            'completed' => $completed,
            'yet_to_start' => $yet_to_start,
            'percentages' => $percentages,
        ];
    }
}
