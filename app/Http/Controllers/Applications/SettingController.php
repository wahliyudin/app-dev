<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\SettingService;
use App\Enums\Applications\NavItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\Setting\StoreRequest;

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

    public function store(StoreRequest $request)
    {
        try {
            $this->settingService->store($request);
            return response()->json([
                'message' => 'Setting saved successfully!',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
