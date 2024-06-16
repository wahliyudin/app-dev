<?php

use App\Models\User;
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
