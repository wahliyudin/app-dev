<?php

namespace App\Http\Controllers;

use App\Domain\Services\Applications\MyAppService;

class HomeController extends Controller
{
    public function __construct(
        protected MyAppService $myAppService
    ) {
    }

    public function index()
    {
        return view('dashboard', [
            'currentApp' => $this->myAppService->getCurrentApp(),
            'taskSummary' => $this->myAppService->getTaskSummary(),
        ]);
    }
}
