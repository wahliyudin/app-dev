<?php

use App\Models\HCIS\Employee;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

if (!function_exists('authUser')) {
    function authUser(): ?User
    {
        return auth()->user();
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
    function employeeByNIK($nik = null): ?Employee
    {
        return Employee::where('nik', $nik ?? userAuth()->nik)
            ->with(['position.divisi', 'position.project', 'position.department'])
            ->first();
    }
}
