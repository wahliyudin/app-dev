<?php

use App\Domain\Services\HCIS\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', function (Request $request) {
    /** @var EmployeeService $service */
    $service = app(EmployeeService::class);
    return $service->getDataForSelect($request->input('q'));
});
