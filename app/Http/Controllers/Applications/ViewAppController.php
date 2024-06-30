<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\ViewAppService;
use App\Enums\Applications\NavItem;
use App\Http\Controllers\Controller;

class ViewAppController extends Controller
{
    public function __construct(
        private ViewAppService $viewAppService
    ) {
    }

    public function index($id)
    {
        return view('applications.view-app', [
            'navItemActive' => NavItem::OVERVIEW,
            'application' => $this->viewAppService->findOrFail($id),
        ]);
    }
}
