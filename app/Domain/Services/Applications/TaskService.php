<?php

namespace App\Domain\Services\Applications;

use App\Data\Applications\TaskDto;
use App\Domain\Websockets\PusherBrodcast;
use App\Enums\Request\Task\Status;
use App\Models\Request\RequestFeatureTask;
use App\Models\Request\RequestTaskDeveloper;
use Illuminate\Support\Facades\DB;

class TaskService extends ApplicationService
{
    public function getTaskByRequest($key)
    {
        return RequestFeatureTask::query()->withWhereHas('feature', function ($query) use ($key) {
            $query->where('application_id', $key);
        })
            ->with(['developers' => function ($query) {
                $query->with(['developer' => function ($query) {
                    $query->select('nik', 'nama_karyawan')
                        ->with('identity:nik,avatar');
                }]);
            }])
            ->when(!hasRole('administrator'), function ($query) {
                $query->whereHas('developers', function ($query) {
                    $query->where('nik', authUser()?->nik);
                });
            })
            ->oldest('due_date')
            ->get()
            ->map(fn(RequestFeatureTask $task) => TaskDto::fromModel($task));
    }

    public function findOrFailTask($id)
    {
        return RequestFeatureTask::with(['feature', 'developers'])->findOrFail($id);
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $status = Status::resetId($request->status);
            $task = RequestFeatureTask::query()->updateOrCreate([
                'request_feature_id' => $request->feature_id,
                'id' => $request->key,
            ], [
                'request_feature_id' => $request->feature_id,
                'due_date' => $request->due_date,
                'status' => $status,
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
            $task = TaskDto::fromModel($task);
            $this->updatedTask($request->key, $request->status, $task);
            return $task;
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
            $task = TaskDto::fromModel($task);
            $this->movedTask($to->id(), $task);
            return [
                'from' => $from,
                'to' => $to->label(),
                'task' => $task,
            ];
        });
    }

    public function destroy($key)
    {
        return DB::transaction(function () use ($key) {
            RequestFeatureTask::query()->findOrFail($key)->delete();
        });
    }

    public function updatedTask($key, $status, TaskDto $task)
    {
        try {
            PusherBrodcast::send("app-dev-task", 'update-item', [
                '_token' => session()->token(),
                'key' => $key,
                'status' => $status,
                'task' => $task
            ]);
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
        }
    }

    public function movedTask($target, TaskDto $task)
    {
        try {
            PusherBrodcast::send("app-dev-task", 'move-item', [
                '_token' => session()->token(),
                'targetBoardID' => $target,
                'task' => $task
            ]);
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
        }
    }
}
