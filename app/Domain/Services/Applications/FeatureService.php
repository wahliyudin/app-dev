<?php

namespace App\Domain\Services\Applications;

use App\Enums\Request\Task\Status;
use App\Models\Request\RequestFeature;
use Illuminate\Support\Facades\DB;

class FeatureService extends ApplicationService
{
    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            return RequestFeature::query()->updateOrCreate([
                'id' => $request->key,
                'application_id' => $request->application_id,
            ], [
                'application_id' => $request->application_id,
                'name' => $request->name,
                'description' => $request->description,
            ]);
        });
    }

    public function getFeatures($appId)
    {
        return RequestFeature::query()
            ->where('application_id', $appId)
            ->latest()
            ->get();
    }

    public function findOrFailFeature($key)
    {
        return RequestFeature::query()->findOrFail($key);
    }

    public function destroy($key)
    {
        return DB::transaction(function () use ($key) {
            RequestFeature::query()->findOrFail($key)->delete();
        });
    }

    public function totalTaskEachStatusByAppId($appId)
    {
        $features = RequestFeature::query()
            ->where('application_id', $appId)
            ->withCount(['tasks as total_open' => function ($query) {
                $query->where('status', Status::NOTTING);
            }, 'tasks as total_progress' => function ($query) {
                $query->where('status', Status::IN_PROGRESS);
            }, 'tasks as total_done' => function ($query) {
                $query->where('status', Status::DONE);
            }])
            ->get();
        return [
            'total_open' => $features?->sum('total_open'),
            'total_progress' => $features?->sum('total_progress'),
            'total_done' => $features?->sum('total_done'),
        ];
    }
}
