<?php

namespace App\Domain\Sidebars;

use Illuminate\Support\Facades\File;

class Sidebar
{
    public static function modules()
    {
        $result = [];
        foreach (File::allFiles(base_path('app/Domain/Sidebars/Modules')) as $file) {
            $relativePath = str_replace('\\', '/', $file->getRelativePathname());
            $pathParts = explode('/', $relativePath);
            $arr = &$result;
            foreach ($pathParts as $i => $part) {
                $part = str($part)->lower()->value();
                if ($i == count($pathParts) - 1) {
                    $className = 'App\Domain\Sidebars\Modules\\' .
                        str_replace('/', '\\', $file->getRelativePath()) .
                        "\\" .
                        $file->getFilenameWithoutExtension();
                    $className = str_replace('\\\\', '\\', $className);
                    $part = str($file->getFilenameWithoutExtension())->lower()->value();
                    if (!(new $className()) instanceof \App\Domain\Sidebars\Contracts\SidebarInterface) {
                        throw new \Exception("Class $className not implements SidebarInterface");
                    }
                    $arr[$part] = new $className();
                } else {
                    if (!isset($arr[$part])) {
                        $arr[$part] = [];
                    }
                    $arr = &$arr[$part];
                }
            }
        }
        return $result;
    }

    public static function build()
    {
        $modules = self::modules();
        $results = [];
        foreach ($modules as $key => $module) {
            if (is_array($module)) {
                $total = array_reduce($module, function ($carry, $mod) use ($key) {
                    return $carry + $mod->total();
                }, 0);
                $results = array_merge($results, array_map(function ($mod, $secondKey) use ($key, $total) {
                    return [
                        'selector' => "#$key #$secondKey",
                        'value' => $mod->total(),
                    ];
                }, $module, array_keys($module)));
                $results[] = [
                    'selector' => "#$key #grand-total",
                    'value' => $total,
                ];
            } else {
                $results[] = [
                    'selector' => "#$key",
                    'value' => $module->total(),
                ];
            }
        }
        return $results;
    }
}
