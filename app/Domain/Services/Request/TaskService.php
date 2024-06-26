<?php

namespace App\Domain\Services\Request;

use App\Enums\Request\Task\Status;
use App\Enums\Request\TypeRequest;
use App\Enums\Workflows\Status as WorkflowsStatus;
use App\Models\Request\Request;
use App\Models\Request\RequestFeature;
use App\Models\Request\RequestFeatureTask;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function getByTask()
    {
        return $this->queryTask()->get();
    }

    public function totalTask()
    {
        return $this->queryTask()->count();
    }

    private function queryTask()
    {
        return Request::select(['id', 'code', 'nik_requestor', 'department', 'application_id', 'type_request', 'type_budget', 'date', 'estimated_project', 'status'])
            ->with(['requestor:nik,nama_karyawan', 'application:id,name,display_name'])
            ->where('status', WorkflowsStatus::CLOSE)
            ->whereHas('features')
            ->where('type_request', TypeRequest::NEW_APPLICATION);
    }

    public function getTaskByRequest($key)
    {
        return RequestFeatureTask::query()->withWhereHas('feature', function ($query) use ($key) {
            $query->where('request_id', $key);
        })
            ->latest()
            ->get();
    }

    public function findOrFail($key)
    {
        return Request::query()
            ->with('features')
            ->findOrFail($key);
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            return RequestFeatureTask::query()->updateOrCreate([
                'request_feature_id' => $request->feature_id,
                'id' => $request->key,
            ], [
                'request_feature_id' => $request->feature_id,
                'status' => Status::resetId($request->status),
                'content' => $request->content,
            ])
                ->load('feature');
        });
    }

    public function update($request, $key)
    {
        return DB::transaction(function () use ($request, $key) {
            $task = RequestFeatureTask::query()->findOrFail($key);
            $from = $task->status->label();
            $to = Status::resetId($request->status);
            $task->update([
                'status' => $to,
            ]);
            return [
                'from' => $from,
                'to' => $to->label(),
            ];
        });
    }

    public function destroy($key)
    {
        return DB::transaction(function () use ($key) {
            RequestFeatureTask::query()->findOrFail($key)->delete();
        });
    }

    public function storeFeature($request)
    {
        return DB::transaction(function () use ($request) {
            return RequestFeature::query()->updateOrCreate([
                'id' => $request->key,
                'request_id' => $request->request_id,
            ], [
                'request_id' => $request->request_id,
                'name' => $request->name,
                'description' => $request->description,
            ]);
        });
    }

    public function getFeatures()
    {
        return RequestFeature::query()
            ->latest()
            ->get();
    }

    public function findOrFailFeature($key)
    {
        return RequestFeature::query()->findOrFail($key);
    }

    public function destroyFeature($key)
    {
        return DB::transaction(function () use ($key) {
            RequestFeature::query()->findOrFail($key)->delete();
        });
    }
}
