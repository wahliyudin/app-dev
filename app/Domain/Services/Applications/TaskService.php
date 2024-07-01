<?php

namespace App\Domain\Services\Applications;

use App\Enums\Request\Task\Status;
use App\Models\Request\RequestFeatureTask;
use Illuminate\Support\Facades\DB;

class TaskService extends ApplicationService
{
    public function getTaskByRequest($key)
    {
        return RequestFeatureTask::query()->withWhereHas('feature', function ($query) use ($key) {
            $query->where('request_id', $key);
        })
            ->latest()
            ->get();
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
            ])
                ->load('feature');
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
}
