<?php

namespace App\Http\Controllers;

use App\Domain\Services\Request\TaskService;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {
    }

    public function index()
    {
        return view('task.index', [
            'tasks' => $this->taskService->getTasks(),
            'apps' => $this->taskService->apps(),
            'permission' => [
                'is_create' => hasPermission('application_task_create'),
                'is_update' => hasPermission('application_task_update'),
                'is_delete' => hasPermission('application_task_delete'),
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

    public function update(UpdateRequest $request, $id)
    {
        try {
            $data = $this->taskService->update($request, $id);
            return response()->json([
                'message' => 'Task updated successfully',
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            $task = $this->taskService->findOrFailTask($id);
            return response()->json([
                'key' => $task->getKey(),
                'status' => $task->status->id(),
                'content' => $task->content,
                'app_id' => $task->feature?->application_id,
                'feature_id' => $task->feature->getKey(),
                'due_date' => $task->due_date,
                'developers' => $task->developers->pluck('nik')->toArray(),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $this->taskService->destroy($id);
            return response()->json([
                'message' => 'Task deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function features($key)
    {
        try {
            return response()->json([
                'data' => $this->taskService->getFeatures($key),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function developers($key)
    {
        try {
            return response()->json([
                'data' => $this->taskService->getDevelopers($key),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
