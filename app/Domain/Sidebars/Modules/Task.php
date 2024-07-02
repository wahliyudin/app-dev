<?php

namespace App\Domain\Sidebars\Modules;

use App\Domain\Services\Request\TaskService;
use App\Domain\Sidebars\Contracts\SidebarInterface;

class Task implements SidebarInterface
{
    public function total(): int
    {
        /** @var TaskService $service */
        $service = app(TaskService::class);
        return $service->totalOutstanding();
    }
}
