<?php

namespace App\Domain\Services\Applications;

use App\Models\Request\RequestFeature;
use Illuminate\Support\Facades\DB;

class FeatureService extends ApplicationService
{
    public function store($request)
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

    public function getFeatures($requestId)
    {
        return RequestFeature::query()
            ->where('request_id', $requestId)
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
}
