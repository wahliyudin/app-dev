<?php

namespace App\Domain\Services\Request;

use App\Data\Applications\TaskDto;
use App\Domain\Services\Applications\TaskService as ApplicationsTaskService;
use App\Enums\Request\Task\Status;
use App\Models\Request\RequestApplication;
use App\Models\Request\RequestFeature;
use App\Models\Request\RequestFeatureTask;
use App\Models\Request\RequestTaskDeveloper;

class TaskService extends ApplicationsTaskService
{
    public function totalOutstanding()
    {
        return $this->queryTasks()->where('status', '!=', Status::DONE)->count();
    }

    public function getTasks()
    {
        return $this->queryTasks()->get()
            ->map(fn ($task) => TaskDto::fromModel($task));
    }

    public function queryTasks()
    {
        return RequestFeatureTask::query()
            ->withWhereHas('developers', function ($query) {
                $query->where('nik', authUser()?->nik)
                    ->with(['developer' => function ($query) {
                        $query->select('nik', 'nama_karyawan')
                            ->with('identity:nik,avatar');
                    }]);
            });
    }

    public function apps()
    {
        return RequestApplication::query()
            ->select(['id', 'display_name'])
            ->get();
    }

    public function getFeatures($key)
    {
        return RequestFeature::query()
            ->select(['id', 'name', 'application_id'])
            ->where('application_id', $key)
            ->get();
    }

    public function getDevelopers($key)
    {
        return RequestTaskDeveloper::query()
            ->select(['nik', 'request_feature_task_id'])
            ->whereHas('task', function ($query) use ($key) {
                $query->where('request_feature_id', $key);
            })
            ->with(['developer' => function ($query) {
                $query->select('nik', 'nama_karyawan')
                    ->with('identity:nik,avatar');
            }])
            ->distinct('nik')
            ->get();
    }
}
