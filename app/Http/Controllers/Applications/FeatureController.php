<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\FeatureService;
use App\Enums\Applications\NavItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\Feature\StoreRequest;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function __construct(
        private FeatureService $featureService
    ) {
    }

    public function index($id)
    {
        return view('applications.feature', [
            'navItemActive' => NavItem::FEATURE,
            'application' => $this->featureService->findOrFail($id),
        ]);
    }

    public function datatable($id)
    {
        $data = $this->featureService->getFeatures($id);
        return datatables()->of($data)
            ->addColumn('is_update', fn () => hasPermission('application_feature_update'))
            ->addColumn('is_delete', fn () => hasPermission('application_feature_delete'))
            ->addIndexColumn()
            ->make();
    }

    public function store(StoreRequest $request)
    {
        try {
            $feature = $this->featureService->store($request);
            return response()->json([
                'message' => 'Feature saved successfully',
                'data' => [
                    'key' => $feature->getKey(),
                    'name' => $feature->name,
                ]
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($key)
    {
        try {
            $feature = $this->featureService->findOrFailFeature($key);
            return response()->json([
                'key' => $feature->getKey(),
                'name' => $feature->name,
                'description' => $feature->description,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($key)
    {
        try {
            $this->featureService->destroy($key);
            return response()->json([
                'message' => 'Feature deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
