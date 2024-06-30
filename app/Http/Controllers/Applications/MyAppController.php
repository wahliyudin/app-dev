<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\MyAppService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyAppController extends Controller
{
    public function __construct(
        private MyAppService $myAppService
    ) {
    }

    public function index(Request $request)
    {
        $status = $request->get('status') == 'all' ? null : $request->get('status');
        return view('applications.my-app', [
            'applications' => $this->myAppService->getApps($status),
        ]);
    }
}
