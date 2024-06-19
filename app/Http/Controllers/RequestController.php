<?php

namespace App\Http\Controllers;

use App\Domain\Services\HCIS\EmployeeService;
use App\Domain\Services\RequestService;
use App\Models\Request\RequestAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RequestController extends Controller
{
    public function __construct(
        protected RequestService $requestService,
        protected EmployeeService $employeeService,
    ) {
    }

    public function index()
    {
        return view('request.index');
    }

    public function datatable()
    {
        $data = $this->requestService->datatable();
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
            ->editColumn('status', function ($data) {
                return $data->status->badge();
            })
            ->addColumn('is_edit', fn ($data) => hasPermission('request_update'))
            ->addColumn('is_delete', fn ($data) => hasPermission('request_delete'))
            ->rawColumns(['action', 'status'])
            ->make();
    }

    public function create()
    {
        return view('request.create');
    }

    public function store(Request $request)
    {
        try {
            $this->requestService->store($request);
            return response()->json([
                'message' => 'Request created successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($key)
    {
        return view('request.edit', [
            'request' => $this->requestService->findOrFail($key),
        ]);
    }

    public function show($key)
    {
        return view('request.show', [
            'request' => $this->requestService->findOrFail($key),
        ]);
    }

    public function destroy($id)
    {
        try {
            $this->requestService->destroy($id);
            return response()->json([
                'message' => 'Request deleted successfully',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function upload(Request $request)
    {
        try {
            $result = [];
            foreach ($request->allFiles() as $files) {
                foreach ($files as $file) {
                    $name = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    // $fullName = pathinfo($name, PATHINFO_FILENAME);
                    $fileName = Str::random(40) . '.' . $extension;
                    $path = $file->storeAs('requests/temp', $fileName, 'public');
                    $result[] = [
                        'oldname' => $name,
                        'newname' => $fileName,
                        'path' => $path,
                        'path_download' => '/storage/' . $path,
                    ];
                }
            }
            return response()->json($result);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function remove(Request $request)
    {
        try {
            $file = str_replace('storage/', '', $request->file);
            if (!Storage::disk('public')->exists($file)) {
                throw ValidationException::withMessages(['File not found']);
            }
            Storage::disk('public')->delete($file);
            return response()->json();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function files($key)
    {
        $attachments = RequestAttachment::where('request_id', $key)->get();
        $result = array_map(function ($attachment) {
            return [
                'name' => $attachment['name'],
                'original_name' => $attachment['original_name'],
                'size' => Storage::disk('public')->size(str_replace('storage/', '', $attachment['path'])),
                'path' => '/' . $attachment['path'],
                'link_download' => Storage::url(str_replace('storage/', '', $attachment['path'])),
            ];
        }, $attachments->toArray());
        return response()->json($result);
    }

    public function employees(Request $request)
    {
        $searchTerm = $request->input('q');
        $data = $this->employeeService->getDataForSelect($searchTerm);
        return response()->json(['results' => $data]);
    }
}
