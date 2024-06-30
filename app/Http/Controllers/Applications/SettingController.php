<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\SettingService;
use App\Enums\Applications\NavItem;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function __construct(
        private SettingService $settingService,
    ) {
    }

    public function index($id)
    {
        return view('applications.setting', [
            'navItemActive' => NavItem::SETTING,
            'application' => $this->settingService->findOrFail($id),
        ]);
    }
}
