<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\ActivityService;
use App\Enums\Applications\NavItem;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function __construct(
        private ActivityService $activityService
    ) {
    }

    public function index($id)
    {
        return view('applications.activity', [
            'navItemActive' => NavItem::ACTIVITY,
            'application' => $this->activityService->findOrFail($id),
        ]);
    }
}
