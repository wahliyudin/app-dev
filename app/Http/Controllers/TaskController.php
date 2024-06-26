<?php

namespace App\Http\Controllers;

use App\Domain\Services\Request\TaskService;
use App\Http\Requests\Task\Feature\StoreRequest as FeatureStoreRequest;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Request\RequestFeatureTask;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {
    }

    public function index()
    {
        return view('task.index');
    }

    public function datatable()
    {
        $data = $this->taskService->getByTask();
        return datatables()->of($data)
            ->editColumn('application', function ($data) {
                return $data->application->display_name;
            })
            ->editColumn('requestor', function ($data) {
                return $data->requestor?->nama_karyawan;
            })
            ->editColumn('type_request', function ($data) {
                return $data->type_request->label();
            })
            ->editColumn('type_budget', function ($data) {
                return $data->type_budget->label();
            })
            ->addColumn('start_date', function ($data) {
                return $data->date ? carbon($data->date)->translatedFormat('d F Y') : '-';
            })
            ->addColumn('estimated_date', function ($data) {
                return $data->estimated_project ? carbon($data->estimated_project)->translatedFormat('d F Y') : '-';
            })
            ->make();
    }

    public function datatableFeatures()
    {
        $data = $this->taskService->getFeatures();
        return datatables()->of($data)
            ->addIndexColumn()
            ->make();
    }

    public function show($key)
    {
        return view('task.show', [
            'requestModel' => $this->taskService->findOrFail($key),
            'tasks' => $this->taskService->getTaskByRequest($key),
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
            $task = RequestFeatureTask::with('feature')->findOrFail($key);
            return response()->json([
                'key' => $task->getKey(),
                'status' => $task->status->id(),
                'content' => $task->content,
                'feature_id' => $task->feature->getKey(),
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

    public function storeFeature(FeatureStoreRequest $request)
    {
        try {
            $feature = $this->taskService->storeFeature($request);
            return response()->json([
                'message' => 'Feature saved successfully',
                'data' => [
                    'key' => $feature->getKey(),
                    'name' => $feature->name,
                ]
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editFeature($key)
    {
        try {
            $feature = $this->taskService->findOrFailFeature($key);
            return response()->json([
                'key' => $feature->getKey(),
                'name' => $feature->name,
                'description' => $feature->description,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroyFeature($key)
    {
        try {
            $this->taskService->destroyFeature($key);
            return response()->json([
                'message' => 'Feature deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
