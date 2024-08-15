<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\FeatureService;
use App\Domain\Services\Applications\MyAppService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyAppController extends Controller
{
    public function __construct(
        private MyAppService $myAppService,
        private FeatureService $featureService,
    ) {}

    public function index(Request $request)
    {
        $status = $request->get('status') == 'all' ? null : $request->get('status');
        return view('applications.my-app', [
            'applications' => $this->myAppService->getApps($status),
            'currentApp' => $this->myAppService->getCurrentApp(),
            'taskSummary' => $this->myAppService->getTaskSummary(),
        ]);
    }

    public function totalTaskEachStatusByAppId($app_id)
    {
        try {
            $data = $this->featureService->totalTaskEachStatusByAppId($app_id);
            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
