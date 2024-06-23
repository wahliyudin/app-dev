<?php

namespace App\Http\Controllers\Approval;

use App\Domain\Services\Request\RequestService;
use App\Domain\Services\Request\RequestWorkflow;
use App\Enums\Workflows\LastAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct(
        private RequestService $requestService,
    ) {
    }

    public function index()
    {
        return view('approval.request.index');
    }

    public function datatable()
    {
        $data = $this->requestService->getByCurrentApproval();
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

    public function show($key)
    {
        return view('approval.request.show', [
            'request' => $this->requestService->findOrFail($key),
        ]);
    }

    public function approv($key)
    {
        try {
            $request = $this->requestService->findOrFail($key);
            RequestWorkflow::setModel($request)->lastAction(LastAction::APPROV);
            return response()->json([
                'message' => 'Berhasil Diverifikasi.'
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function reject(Request $request, $key)
    {
        try {
            $requestModel = $this->requestService->findOrFail($key);
            RequestWorkflow::setModel($requestModel)->lastAction(LastAction::REJECT, $request->note);
            return response()->json([
                'message' => 'Berhasil Direject.'
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
