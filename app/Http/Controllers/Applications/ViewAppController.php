<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\ViewAppService;
use App\Enums\Applications\NavItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewAppController extends Controller
{
    public function __construct(
        private ViewAppService $viewAppService
    ) {
    }

    public function index($id)
    {
        $app = $this->viewAppService->findOrFail($id);
        return view('applications.view-app', [
            'navItemActive' => NavItem::OVERVIEW,
            'application' => $app,
            'taskSummary' => $this->viewAppService->getTaskSummary($app->request->id),
            'quarters' => $this->viewAppService->quarterOptions(),
            'developers' => $this->viewAppService->getDevelopers($app->request->id),
        ]);
    }

    public function taskOvertime(Request $request)
    {
        try {
            return response()->json([
                'data' => $this->viewAppService->getTaskOvertime($request->year, $request->quarter),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
