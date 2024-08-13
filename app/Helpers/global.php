<?php

use App\Domain\Gateway\Dto\EmployeeDto;
use App\Domain\Gateway\Services\EmployeeService;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

if (!function_exists('authUser')) {
    function authUser(): ?User
    {
        return auth()->user();
    }
}

if (!function_exists('hasRole')) {
    function hasRole($role)
    {
        return auth()->user()->hasRole($role);
    }
}

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        return auth()->user()->hasPermission($permission);
    }
}

if (!function_exists('pathWeb')) {
    function pathWeb()
    {
        $web = [
            base_path('routes/web.php')
        ];
        foreach (File::allFiles(rtrim(app()->basePath('routes/web/'), '/')) as $file) {
            $web[] = $file->getPathname();
        }
        return $web;
    }
}

if (!function_exists('carbon')) {
    function carbon($date)
    {
        return new Carbon($date);
    }
}

if (!function_exists('userAuth')) {
    function userAuth(): ?User
    {
        return auth()->user();
    }
}

if (!function_exists('employeeByNIK')) {
    function employeeByNIK($nik = null)
    {
        /** @var EmployeeService $employeeService */
        $employeeService = app(EmployeeService::class);
        $employee = $employeeService->with(['position.divisi', 'position.project', 'position.department'])
            ->where('nik', $nik ?? userAuth()->nik)
            ->first();
        return EmployeeDto::from($employee);
    }
}

if (!function_exists('quarterDateRange')) {
    function quarterDateRange($quarter, $year = null)
    {
        $year = $year ?? now()->year;
        $startDate = Carbon::create($year, $quarter * 3 - 2, 1)->startOfMonth();
        $endDate = Carbon::create($year, $quarter * 3, 1)->endOfMonth();
        return [
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
        ];
    }
}

if (!function_exists('quarterDateRangeMonth')) {
    function quarterDateRangeMonth($quarter, $year = null)
    {
        $year = $year ?? now()->year;
        $startMonth = ($quarter - 1) * 3 + 1;
        $endMonth = $quarter * 3;
        $months = range($startMonth, $endMonth);

        $formattedMonths = array_map(function ($month) use ($year) {
            return Carbon::createFromDate($year, $month, 1)->translatedFormat('M');
        }, $months);

        return $formattedMonths;
    }
}
