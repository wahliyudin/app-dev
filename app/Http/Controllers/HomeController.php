<?php

namespace App\Http\Controllers;

use App\Domain\Services\Applications\ApplicationService;
use App\Domain\Services\Applications\DeveloperService;
use App\Domain\Services\Applications\MyAppService;

class HomeController extends Controller
{
    public function __construct(
        protected MyAppService $myAppService,
        protected DeveloperService $developerService,
        protected ApplicationService $applicationService,
    ) {}

    public function index()
    {
        return view('dashboard', [
            'currentApp' => $this->myAppService->getCurrentApp(),
            'taskSummary' => $this->myAppService->getTaskSummary(),
            'developers' => $this->developerService->getAllDevelopers()
        ]);
    }

    public function applications()
    {
        $data = $this->applicationService->getAll();
        return datatables()->of($data)
            ->editColumn('logo', function ($data) {
                return $data->logo();
            })
            ->editColumn('due_date', function ($data) {
                return carbon($data->due_date)->translatedFormat('j F Y');
            })
            ->editColumn('status', function ($data) {
                return $data->status->badge();
            })
            ->rawColumns(['status'])
            ->make();
    }
}
