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
}
