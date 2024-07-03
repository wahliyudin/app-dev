<?php

namespace App\Domain\Services\Applications;

use App\Data\Applications\TaskDto;
use App\Enums\Request\Task\Status;
use App\Models\Request\RequestFeatureTask;
use App\Models\Request\RequestTaskDeveloper;
use Illuminate\Support\Facades\DB;

class TaskService extends ApplicationService
{
    public function getTaskByRequest($key)
    {
        return RequestFeatureTask::query()->withWhereHas('feature', function ($query) use ($key) {
            $query->where('request_id', $key);
        })
            ->with(['developers' => function ($query) {
                $query->with(['developer' => function ($query) {
                    $query->select('nik', 'nama_karyawan')
                        ->with('identity:nik,avatar');
                }]);
            }])
            ->latest()
            ->get()
            ->map(fn ($task) => TaskDto::fromModel($task));
    }

    public function findOrFailTask($id)
    {
        return RequestFeatureTask::with(['feature' => function ($query) {
            $query->with(['request:id,application_id']);
        }, 'developers'])->findOrFail($id);
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $task = RequestFeatureTask::query()->updateOrCreate([
                'request_feature_id' => $request->feature_id,
                'id' => $request->key,
            ], [
                'request_feature_id' => $request->feature_id,
                'due_date' => $request->due_date,
                'status' => Status::resetId($request->status),
                'content' => $request->content,
            ]);
            foreach ($request->developers as $developer) {
                RequestTaskDeveloper::query()->updateOrCreate([
                    'request_feature_task_id' => $task->getKey(),
                    'nik' => $developer,
                ], [
                    'request_feature_task_id' => $task->getKey(),
                    'nik' => $developer,
                ]);
            }
            RequestTaskDeveloper::query()->where('request_feature_task_id', $task->getKey())->whereNotIn('nik', $request->developers)->delete();
            return TaskDto::fromModel($task);
        });
    }

    public function update($request, $key)
    {
        return DB::transaction(function () use ($request, $key) {
            $task = RequestFeatureTask::query()->with('feature')->findOrFail($key);
            $from = $task->status->label();
            $to = Status::resetId($request->status);
            $task->update([
                'status' => $to,
            ]);
            return [
                'from' => $from,
                'to' => $to->label(),
                'task' => TaskDto::fromModel($task),
            ];
        });
    }

    public function destroy($key)
    {
        return DB::transaction(function () use ($key) {
            RequestFeatureTask::query()->findOrFail($key)->delete();
        });
    }
}
