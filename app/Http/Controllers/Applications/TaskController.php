<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\TaskService;
use App\Enums\Applications\NavItem;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService,
    ) {
    }

    public function index($id)
    {
        return view('applications.task', [
            'navItemActive' => NavItem::TASK,
            'application' => $this->taskService->findOrFail($id),
        ]);
    }
}
