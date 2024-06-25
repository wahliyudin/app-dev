<?php

namespace App\Http\Controllers;

use App\Domain\Services\Request\RequestService;
use App\Http\Requests\Task\StoreRequest;
use App\Models\Request\RequestFeatureTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        protected RequestService $requestService
    ) {
    }

    public function index()
    {
        return view('task.index');
    }

    public function datatable()
    {
        $data = $this->requestService->getByTask();
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

    public function show($key)
    {
        return view('task.show', [
            'requestModel' => $this->requestService->findOrFailForTask($key),
            'tasks' => $this->requestService->getTaskByRequest($key),
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $task = $this->requestService->storeTask($request);
            return response()->json($task);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $key)
    {
        try {
            $data = $this->requestService->updateTask($request, $key);
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
            $this->requestService->destroyTask($key);
            return response()->json([
                'message' => 'Task deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
