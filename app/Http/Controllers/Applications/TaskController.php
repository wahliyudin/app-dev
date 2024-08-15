<?php

namespace App\Http\Controllers\Applications;

use App\Domain\Services\Applications\TaskService;
use App\Enums\Applications\NavItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\Task\StoreRequest;
use App\Http\Requests\Applications\Task\UpdateRequest;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService,
    ) {}

    public function index($id)
    {
        $app = $this->taskService->findOrFail($id);
        return view('applications.task', [
            'navItemActive' => NavItem::TASK,
            'application' => $app,
            'tasks' => $this->taskService->getTaskByRequest($app->id),
            'permission' => [
                'is_create' => hasPermission('application_task_create'),
                'is_update' => hasPermission('application_task_update'),
                'is_delete' => hasPermission('application_task_delete'),
                'is_developer' => hasRole('developer'),
            ],
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $task = $this->taskService->store($request);
            return response()->json($task);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(UpdateRequest $request, $key)
    {
        try {
            $data = $this->taskService->update($request, $key);
            return response()->json([
                'message' => 'Task updated successfully',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($key)
    {
        try {
            $task = $this->taskService->findOrFailTask($key);
            return response()->json([
                'key' => $task->getKey(),
                'status' => $task->status->id(),
                'content' => $task->content,
                'feature_id' => $task->feature->getKey(),
                'due_date' => $task->due_date,
                'developers' => $task->developers->pluck('nik')->toArray(),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($key)
    {
        try {
            $this->taskService->destroy($key);
            return response()->json([
                'message' => 'Task deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
